import config from './config.js';
import axios from 'axios';
import { guid, tap, debouncePromise } from '../core/helper.js';
import { createErrorDescriptionDOM, warningModal } from '../core/warning.js';
import { debounce } from 'lodash';
import {
    CODE_EXCEPTION_CSRF,
    CODE_EXCEPTION_INCOMPLETE_POST,
    CODE_EXCEPTION_AUTHORIZATION,
    CODE_EXCEPTION_UNAUTHORIZED,
    CODE_EXCEPTION_ACCESS_DENIED,
    CODE_EXCEPTION_WITH_MESSAGE,
    CODE_EXCEPTION_VALIDATION,
} from '../config/constant.js';
import { ElMessageBox, ElNotification } from 'element-plus';

// allow use http client without Vue instance
export const http = axios.create({
    headers: {
        'X-CSRF-TOKEN': document.head.querySelector('[name=csrf]') ? document.head.querySelector('[name=csrf]').content : (window.app ? window.app.csrf : null),
        'X-Requested-With': 'XMLHttpRequest',
    },
    timeout: 8000,
});

export const getErrorMessage = function(error) {
    return _.get(error, ['response', 'data', 'data', 'message']) || _.get(error, ['response', 'data', 'message']) || _.get(error, ['response', 'message']) || _.get(error, 'message');
};

export const getErrorText = function(error) {
    let errorParts = [];
    let status = _.get(error, ['response', 'status']);
    let errorMessage = getErrorMessage(error);
    let trace = _.get(error, ['response', 'data', 'debug']);
    if (status) {
        errorParts.push(`HTTP Status: ${status}`);
    }
    if (errorMessage) {
        errorParts.push(errorMessage);
    } else {
        errorParts.push('unidentified error');
    }
    if (trace) {
        errorParts.push(JSON.stringify(trace, null, '   '));
    }
    return errorParts.join('\n');
};

export const getRequestSummaryText = function(config) {
    let requestParts = [];
    let {data, method, url} = config.getProperties();
    let dataText = JSON.stringify(data, null, '\t');
    requestParts.push(method);
    requestParts.push(url);
    if (dataText) {
        requestParts.push(dataText);
    }
    return requestParts.join('\n');
};

// зарегистрировать конфиг запроса для вывода предупреждения по нему, конфиг может быть выведен
// вместе с несоколькими другими, зарегистрированными в короткий промежуток времени
export const registerRequestWarning = function(config, error, props) {
    if (config.hasOwnProperty('silent') && config.silent === true) {
        return Promise.reject(error);
    }
    return new Promise((resolve, reject) => {
        httpPromiseWrapper.modalWarningBuffer.push({config, error, resolve, reject});
        httpPromiseWrapper.showWarningModal(error, props);
    });
};

// список типов попыток запроса
const AttemptMode = {
    INITIAL_ATTEMPT: 0,
    AUTO_RETRY: 1,
    MANUAL_RETRY: 2,
    REHANDLE: 3,
    ACCEPTED_202: 4,
    NETWORK_ERROR: 6,
    EXCEPTION: 7,
    AUTH: 8,
    ACCESS: 9,
    CSRF: 10,
    NOMODE: 11,
    INCOMPLETE_POST: 12,
    MESSAGE: 13,
    VALIDATION: 14,
};

const exceptionCodeToMode = {
    [CODE_EXCEPTION_CSRF]: AttemptMode.CSRF,
    [CODE_EXCEPTION_INCOMPLETE_POST]: AttemptMode.INCOMPLETE_POST,
    [CODE_EXCEPTION_AUTHORIZATION]: AttemptMode.AUTH,
    [CODE_EXCEPTION_UNAUTHORIZED]: AttemptMode.AUTH,
    [CODE_EXCEPTION_ACCESS_DENIED]: AttemptMode.ACCESS,
    [CODE_EXCEPTION_WITH_MESSAGE]: AttemptMode.MESSAGE,
    [CODE_EXCEPTION_VALIDATION]: AttemptMode.VALIDATION,
};

const WrapRequest = function(requestor, requestConfig, wrapper) {
    // это конфиг до отправки изначального запроса - в нём нету части свойств, не годится для аттемптеров
    this.requestConfig = requestConfig;
    this.requestor = requestor;
    this.wrapper = wrapper;

    this.preparedRequestor = function(config) {
        if (config.hasOwnProperty('silent') && config.silent === true) {
            return requestor(config);
        }

        return httpPromiseWrapper
            .runHandlerChain({config: config}, 'onRequest')
            .then(() => {
                return Promise.resolve(wrapper.pausePending).then(() => {
                    let rowGuid = config.headers.Guid;
                    wrapper.allPendingRequests[rowGuid] = {};
                    wrapper.allPendingRequests[rowGuid].promise = new Promise((resolve) => wrapper.allPendingRequests[rowGuid].resolve = resolve);
                    if (config.attemptDelay) {
                        return new Promise((resolve) => {
                            setTimeout(() => resolve(requestor(config)), config.attemptDelay);
                        });
                    }
                    return requestor(config);
                });
            });
    };
};

const AttemptModeAction = {
    [AttemptMode.INITIAL_ATTEMPT](requestWrap, error, config) {
        return requestWrap.preparedRequestor(config);
    },

    [AttemptMode.CSRF](requestWrap, error, config) {
        return registerRequestWarning(config, error, {
            title: 'Token Mismatch error',
            description: createErrorDescriptionDOM({
                descriptionText: 'The session is probably expired in browser. Please, try reload the page. If this does not help, report to us.',
                errorText: [
                    getRequestSummaryText(config),
                    'CSRF: ' + _.get(config, ['headers', 'X-CSRF-TOKEN']),
                    getErrorText(error),
                ].join('\n')
            }),
            icon: 'icon-shield-notice',
            labels: {ok: 'Reload', cancel: 'Cancel'},
            onConfirm() {
                location.reload();
                return false;
            },
            onCancel() {
                api.affectedTokenMismatch = true;
            },
        });
    },

    [AttemptMode.AUTH](requestWrap, error, config) {
        return registerRequestWarning(config, error, {
            title: 'Auth error',
            description: createErrorDescriptionDOM({
                descriptionText: 'Got unexpected authorization error from server. Please, try to log out, then log in again. If the problem persists, please report it.',
                errorText: getErrorMessage(error),
                rows: 2,
            }),
            icon: 'icon-user-lock',
        });
    },

    [AttemptMode.ACCESS](requestWrap, error, config) {
        return registerRequestWarning(config, error, {
            title: 'Access denied',
            description: createErrorDescriptionDOM({
                descriptionText: 'The server responded that you have not been permitted to perform this action. If you think this is a mistake, please report it.',
                errorText: getErrorMessage(error),
                rows: 2,
            }),
            icon: 'icon-lock',
        });
    },

    [AttemptMode.EXCEPTION](requestWrap, error, config) {
        return registerRequestWarning(config, error, {
            title: 'Oops, server error has occurred!',
            description: createErrorDescriptionDOM({
                errorText: [
                    getErrorText(error),
                    getRequestPayload(config)
                ].join('\n'),
                pleaseCopy: true,
            }),
            icon: 'icon-cancel-circle2 uk-text-danger',
            labels: {ok: 'Recover', cancel: 'Cancel'},
        });
    },

    [AttemptMode.MANUAL_RETRY](requestWrap, error, config) {
        return requestWrap.preparedRequestor(config);
    },

    [AttemptMode.NETWORK_ERROR](requestWrap, error, config) {
        return registerRequestWarning(config, error, {
            title: 'Network connection error',
            description: createErrorDescriptionDOM({
                descriptionText: 'Check your network connection or try again later.',
            }),
            icon: 'icon-power-cord',
        });
    },

    [AttemptMode.MESSAGE](requestWrap, error, config) {
        return registerRequestWarning(config, error, {
            title: 'Message',
            description: createErrorDescriptionDOM({
                descriptionText: getErrorMessage(error),
                thankYou: false,
            }),
            icon: 'icon-warning',
        });
    },

    [AttemptMode.VALIDATION](requestWrap, error, config) {
        return httpPromiseWrapper.runHandlerChain(error, 'onValidation', httpPromiseWrapper.defaultHandlerValidation);
    },

    [AttemptMode.REHANDLE](requestWrap, error, config) {
        return registerRequestWarning(config, error, {
            title: 'Oops, looks like a bug',
            description: createErrorDescriptionDOM({
                descriptionText: 'Several repeated attempts to perform the action has failed.',
                errorText: [
                    getRequestSummaryText(config),
                    getErrorText(error),
                ].join('\n'),
                pleaseCopy: true,
            }),
            icon: 'icon-cancel-circle2 uk-text-danger',
            labels: {ok: 'Recover', cancel: 'Cancel'},
            onConfirm() {},
        });
    },

    [AttemptMode.NOMODE](requestWrap, error, config) {
        return registerRequestWarning(config, error, {
            title: 'Oops, frontend error in detection of error!',
            description: createErrorDescriptionDOM({
                errorText: [
                    getRequestSummaryText(config),
                    getErrorText(error),
                ].join('\n'),
                pleaseCopy: true,
            }),
            icon: 'icon-cancel-circle2 uk-text-danger',
            labels: {ok: 'Recover', cancel: 'Cancel'},
        });
    },
};

const EmptyConfig = {
    getProperties: function() {
        return {data: '(unknown)', method: '(unknown)', url: '(unknown)'};
    }
};

const getRequestPayload = function (config) {
    let {data} = config.getProperties();

    return (data
        ? `Request payload sent:\n${JSON.stringify(data, null, '\t')}`
        : 'The request had no payload');
};

http.interceptors.request.use(function(request) {
    if (!request.url) {
        ElNotification({
            message: 'Request not have url',
            type: 'danger',
        });
    }
    if (api.affectedTokenMismatch) {
        return false;
    }
    if (request.state) {
        request.state.isLoading = true;
    }
    return request;
});

const responseInterceptor = function(response) {
    let guid = _.get(response, ['config', 'headers', 'Guid']);
    if (guid) {
        httpPromiseWrapper.allPendingRequests[guid] && httpPromiseWrapper.allPendingRequests[guid].resolve();
        delete httpPromiseWrapper.allPendingRequests[guid];
    }

    // произошёл таймаут
    if (response.status === 202 && response.config.attempter && response.headers['x-retry-after']) {
        return response.config.attempter(AttemptMode.ACCEPTED_202, response);
    }

    let logEntry = _.get(response, ['config', 'logEntry']);
    if (logEntry && response.status !== 200 && response.status !== 202) logEntry.response = JSON.stringify(response.data);
    if (_.has(response, ['config', 'state'])) {
        response.config.state.isLoading = false;
    }

    return httpPromiseWrapper.responseHandlerChainer(response);
};

const errorInterceptor = function (error) {
    let guid = _.get(error, ['config', 'headers', 'Guid']);

    if (guid) {
        httpPromiseWrapper.allPendingRequests[guid] && httpPromiseWrapper.allPendingRequests[guid].resolve();
        delete httpPromiseWrapper.allPendingRequests[guid];
    }

    if (error.status === 502 || error.message === 'Request failed with status code 502') {
        return error.config.attempter(AttemptMode.AUTO_RETRY, error);
    } else if (error.response) {
        let logEntry = _.get(error, ['config', 'logEntry']);
        if (logEntry) {
            logEntry.response = JSON.stringify(_.get(error, ['response', 'data']) || '');
        }
        if (error.response.status === 422) {
            httpPromiseWrapper.defaultHandlerValidation(error);
        }
        return Promise.resolve(error);
        // The request was made and the server responded with a status code
        // return httpPromiseWrapper.exceptionHandlerChainer(error);
    } else if (error && error.code === 'ECONNABORTED') {
        // произошёл таймаут
        if (!error.config) {
            console.error(`Timeout error has no response.config! Error: ${error}\n${JSON.stringify(error, null, '\t')}`);
            ElNotification({
                message: `Timeout error has no response.config! Error: ${error}`,
                type: 'warning',
            });
        } else if (error.config.silent === true) {
            console.error(`Silent request is rejected! Cannot be retry! Error: ${error}\n${JSON.stringify(error, null, '\t')}`);
        } else if (error.config.attempter) {
            return error.config.attempter(AttemptMode.AUTO_RETRY, error);
        } else {
            console.error(`Timeout error has no response.config.attempter! Cannot be retry! Error: ${error}\n${JSON.stringify(error, null, '\t')}`);
            ElNotification({
                message: `Timeout error has no response.config.attempter! Cannot be retry! Error: ${error}`,
                type: 'warning',
            });
        }
        return Promise.resolve(error);
    } else if (error.message === 'Network Error') {
        // The request was made and the server not responded. Network error:
        // ERR_NAME_NOT_RESOLVED
        // ERR_CONNECTION_REFUSED
        // ERR_INTERNET_DISCONNECTED
        // ERR_BLOCKED_BY_CLIENT
        // ERR_TUNNEL_CONNECTION_FAILED (when using proxy)
        return error.config.attempter(AttemptMode.NETWORK_ERROR, error);
    }
};

http.interceptors.response.use(responseInterceptor, errorInterceptor);

const api = {
    // был ли получин ответ с token mismatch
    affectedTokenMismatch: false,

    /**
     * Запрос типа GET
     *
     * @param {String} url - адрес запроса
     * @param {Object} data -  данные
     * @param {Object} config - параметры запроса
     * @param {boolean} config['notify'] - вывод уведомления об успехе
     * @param {boolean} config['notifyMessage'] - текст уведомления об успехе
     * @param {boolean} config['notifyError'] - вывод уведомления о неудаче
     * @callback {Function} config['onSuccess'] - при успехе (объект response)
     * @callback {Function} config['onError'] - при неудаче (объект error|undefined}
     * @return {Promise} - success(result|undefined)
     */
    get: function(url, data, config = {}) {
        let method = 'api.get';
        config.params = data || null;
        return httpPromiseWrapper.wrap((config) => {
            let request = httpPromiseWrapper.requestModifier({url, data, config}, method);
            return http.get(request.url, request.config);
        }, data, config, method, url);
    },

    /**
     * Запрос типа POST
     *
     * @param {String} url - адрес запроса
     * @param {Object} data -  данные
     * @param {Object} config - параметры запроса
     * @param {boolean} config['notify'] - вывод уведомления об успехе
     * @param {boolean} config['notifyMessage'] - текст уведомления об успехе
     * @param {boolean} config['notifyError'] - вывод уведомления о неудаче
     * @callback {Function} config['onSuccess'] - при успехе (объект response)
     * @callback {Function} config['onError'] - при неудаче (объект error|undefined}
     * @return {Promise} - success(result|undefined)
     */
    post: function(url, data, config = {}) {
        let method = 'api.post';
        return httpPromiseWrapper.wrap((config) => {
            let request = httpPromiseWrapper.requestModifier({url, data, config}, method);
            return http.post(request.url, request.data, request.config);
        }, data, config, method, url);
    },

    postInternal: function(url, data, config = {}) {
        return http.post(url, data, config);
    },

    /**
     * Запрос типа PUT
     *
     * @param {String} url - адрес запроса
     * @param {Object} data -  данные
     * @param {Object} config - параметры запроса
     * @param {boolean} config['notify'] - вывод уведомления об успехе
     * @param {boolean} config['notifyMessage'] - текст уведомления об успехе
     * @param {boolean} config['notifyError'] - вывод уведомления о неудаче
     * @callback {Function} config['onSuccess'] - при успехе (объект response)
     * @callback {Function} config['onError'] - при неудаче (объект error|undefined}
     * @return {Promise} - success(result|undefined)
     */
    put: function(url, data, config = {}) {
        let method = 'api.put';
        return httpPromiseWrapper.wrap((config) => {
            let request = httpPromiseWrapper.requestModifier({url, data, config}, method);
            return http.put(request.url, request.data, request.config);
        }, data, config, method, url);
    },

    /**
     * Запрос типа DELETE
     *
     * @param {String} url - адрес запроса
     * @param {Object} data -  данные
     * @param {Object} config - параметры запроса
     * @param {boolean} config['notify'] - вывод уведомления об успехе
     * @param {boolean} config['notifyMessage'] - текст уведомления об успехе
     * @param {boolean} config['notifyError'] - вывод уведомления о неудаче
     * @callback {Function} config['onSuccess'] - при успехе (объект response)
     * @callback {Function} config['onError'] - при неудаче (объект error|undefined}
     * @return {Promise} - success(result|undefined)
     */
    delete: function(url, data, config = {}) {
        let method = 'api.delete';
        config.data = data || null;
        return httpPromiseWrapper.wrap((config) => {
            let request = httpPromiseWrapper.requestModifier({url, data, config}, method);
            return http.delete(request.url, request.config);
        }, data, config, method, url);
    },

    /**
     * для документации смотреть debouncePromise в helper.js
     *
     * @param {Function} operation
     * @param {Number} [delay=0]
     * @return {Function}
     */
    debounce: function(operation, delay = 0) {
        let rowGuid = guid();
        let nextPromise = {};
        nextPromise.promise = new Promise((resolve) => nextPromise.resolve = resolve);
        httpPromiseWrapper.allMultiPendingRequests[rowGuid] = nextPromise;
        return debouncePromise((...argument) => {
            if (nextPromise) {
                httpPromiseWrapper.allMultiPendingRequests[rowGuid] = nextPromise;
                nextPromise = undefined;
            }
            return Promise.resolve(operation(...argument)).finally(() => {
                httpPromiseWrapper.allMultiPendingRequests[rowGuid] && httpPromiseWrapper.allMultiPendingRequests[rowGuid].resolve();
                delete httpPromiseWrapper.allMultiPendingRequests[rowGuid];

                rowGuid = guid();
                nextPromise = {};
                nextPromise.promise = new Promise((resolve) => nextPromise.resolve = resolve);
            });
        }, delay);
    },

    multiple: function(operation) {
        let rowGuid = guid();
        let nextPromise = {};
        nextPromise.promise = new Promise((resolve) => nextPromise.resolve = resolve);
        httpPromiseWrapper.allMultiPendingRequests[rowGuid] = nextPromise;

        return Promise.resolve(operation()).finally(() => {
            httpPromiseWrapper.allMultiPendingRequests[rowGuid] && httpPromiseWrapper.allMultiPendingRequests[rowGuid].resolve();
            delete httpPromiseWrapper.allMultiPendingRequests[rowGuid];
        });
    },

    // вызов окна предупреждения незавершенных запросов
    waitPendingRequests: function() { //rename
        let dialog, blockTimeout = setTimeout(
            () => dialog = ElMessageBox({
                message: 'Waiting for pending requests...',
            }
        ), 300);

        return httpPromiseWrapper.waitWrappedSample().then(() => {
            clearTimeout(blockTimeout);
            dialog && dialog.hide();
        });
    },

    // устанавливает кастомный обработчик ошибок
    setErrorHandler: function (func) {
        httpPromiseWrapper.onError = func;
    },

    // устанавливает кастомный обработчик успешных ответов
    setSuccessHandler: function(func) {
        httpPromiseWrapper.onSuccess = func;
    },

    // устанавливает кастомный обработчик безнадёжных ответов
    setAbortHandler: function(func) {
        httpPromiseWrapper.onAbort = func;
    },

    // устанавливает кастомный обработчик безнадёжных ответов
    setRequestHandler: function(func) {
        httpPromiseWrapper.onRequest = func;
    },

    // set progress request handler. It need for progress bar
    setProgressHandler: function (func) {
       httpPromiseWrapper.onProgress = func;
    },

    // устанавливает кастомный обработчик успешных ответов
    setValidationHandler: function(func) {
       httpPromiseWrapper.onValidation = func;
    },

    // устанавливает подписку на уведомления о наличии очереди запросов
    subscribePending: function(func) {
        httpPromiseWrapper.pendingSubscribers.push(func);
    },

    /**
     * Sets function for modifying request directly before request itself.
     *
     * @param {Function} func
     */
    setRequestModifier: function(func) {
        if (_.isFunction(func)) {
            httpPromiseWrapper.requestModifier = func;
        }
    },
};

/**
 * Класс обработки handler'ов и ретраев
 *
 * Процесс обработки handler'ов:
 * - сначала запускается handler из config запроса
 * - если он вернул значение или Promise с false внутри, следующий handler не идёт
 * - затем следующий handler из setErrorHandler/setSuccessHandler'а
 * - если он вернул значение или Promise с false внутри, следующий handler не идёт
 * - затем проекто-независимый handler
 *
 * Процесс обработки ретраев:
 * - при запросе, оставшемся без ответа в течение config.timeout секунд делается повторная попытка
 * - при нажатии Cancel в модальном окне выводится сообщение об ошибке и ответ ожидаться перестаёт
 * - если при обработке handler'а ошибки был вызван метод config.setReHandle, то делается повторная попытка
 *
 * Handler onSuccess получит только успешные результаты
 * Handler onError получит только неудачные результаты
 * Метод wrap возвращает Promise, который вернёт результат, неважно успешный или неудачный, после всех ретраев
 */
const httpPromiseWrapper = {
    // глобальный кастомные хэндлер успеха
    onSuccess: null,

    // глобальный кастомный хэндлер ошибки
    onError: null,

    // глобальный кастомные хэндлер progress
    onProgress: null,

    // глобальный кастомный хэндлер безнадёжных ответов
    onAbort: null,

    // глобальный кастомные хэндлер валидации ошибок
    onValidation: null,

    onRequest: null,

    /**
     * Global modifier of request.
     *
     * @var {Function|null}
     */
    requestModifier: (request) => request,

    // очередь запросов по группам
    requestStack: {},

    // количество запросов в работе (для state.isLoading)
    requestsTotal: 0,

    // если ретраи не помогают, сделать паузу для вывода предупреждения
    pausePending: false,

    // все запросы в состоянии ожидания
    allPendingRequests: {},

    // все debounce на группу запросов в состоянии ожидания
    allMultiPendingRequests: {},

    // буфер модального окна с предупреждениями
    // содержит коллекцию конфигов запросов и ожидателей Promise выбора модального окна, зарегистрированных
    // в короткий промежуток времени перед выводом модального окна с предупреждением
    modalWarningBuffer: [],

    // подписчики уведомлений об очереди запросов
    pendingSubscribers: [],

    // попытка запуска handler'а
    tryRunHandler(handler, response) {
        try {
            return Promise.resolve(handler(response));
        } catch (error) {
            console.error(`Exception in handler chain: ${error}`, handler);
            ElNotification({
                message: `Exception in handler chain: ${error}`,
                type: 'warning',
            });
            return Promise.resolve();
        }
    },

    // стандартный проекто-независимый обработчик успеха
    responseCallback({data: response, config}) {
        if (_.get(config, 'notify') === true) {
            ElNotification({
                message: _.get(config, 'notifyMessage', (response.message || response.data.message)),
                type: 'success',
            });
        }
    },

    // стандартный проекто-независимый обработчик ошибки
    responseException({data: response, config, describeOperation, describeResponse, describeData}) {
        // that falls out of the range of 2xx
        let code = _.get(response, 'code');
        if (exceptionCodeToMode.hasOwnProperty(code)) {
            if (exceptionCodeToMode[code] !== false) {
                config.setReHandle(exceptionCodeToMode[code]);
            }
        } else {
            config.setReHandle(AttemptMode.EXCEPTION);
        }
    },

    defaultHandlerValidation(error) {
        _.get(error, ['response', 'data', 'data'], []).map((msg) => {
            ElNotification({
                title: 'Validation error',
                message: msg.message,
                type: 'warning',
            });
        });
    },

    // выполнить все handler'ы в определенной последовательности
    runHandlerChain(response, handlerType, defaultGlobalHandler) {
        // последовательность:
        // сначала кастомный обработчик конкретного запроса,
        // затем глобальный кастомный обрабтчик проекта
        // затем стандартный проекто-независимый глобальный обработчик
        let handlers = _.filter([
            response.config[handlerType],
            this[handlerType],
            defaultGlobalHandler
        ], (i) => (i && typeof i === 'function'));

        // выполнить один handler
        // если handler возвращает Promise, то Promise.resolve вберёт его в себя
        let runOneHandler = () => {
            let handler = handlers.shift();
            if (handler) {
                return this.tryRunHandler(handler, response);
            } else {
                return Promise.resolve(false);
            }
        };

        // вызываем следующий handler по списку до тех пор, пока result true-образный или undefined
        // если вернуть false, или Promise со значением false или Promise.resolve(false), то следующий хэндлер не пойдет
        let next = (next) => {
            return runOneHandler().then((result) => (result || result === undefined) ? next(next) : result);
        };

        return next(next);
    },

    // описание операции
    describeOperation(method, handleName, config) {
        if (_.has(config, 'object')) {
            return `${method}::${handleName} (object: ${config.object})`;
        }
        return `${method}::${handleName}`;
    },

    // проинформировать подписчиков состояния загрузки
    informPendingSubscribers() {
        _.each(this.pendingSubscribers, (func) => func(this.requestsTotal));
    },

    // регистрация запроса
    // requestor это такая сущность, которая исполняет одну попытку запроса и понятия не имеет об очереди
    // registerPendingRequest возвращает Promise, который запустит её только в момент освободившейся очереди
    registerPendingRequest(requestor, config) {
        return new Promise((resolve, reject) => {
            let last = this.requestStack[config.object] || Promise.resolve();
            if (!last.pendingAmout) {
                last.pendingAmout = 0;
            }

            ++last.pendingAmout;
            // добавление количества запросов в очереди запросов (используется для state.isLoading)
            ++this.requestsTotal;
            this.informPendingSubscribers();

            this.requestStack[config.object] = last.then(() => {
                return requestor(config).then((result) => {
                    if (--last.pendingAmout === 0) {
                        delete this.requestStack[config.object];
                        --this.requestsTotal;
                        this.informPendingSubscribers();
                    }
                    return resolve(result);
                }).catch((result) => {
                    if (--last.pendingAmout === 0) {
                        delete this.requestStack[config.object];
                        --this.requestsTotal;
                        this.informPendingSubscribers();
                    }
                    return reject(result);
                });
            });
        });
    },

    // дождаться всех текущих запросов (успех, ошибка или модальное окно с предупреждением)
    waitWrappedSample: function () {
        return new Promise((resolve) => {
            let sample = _.sample(this.requestStack);
            return sample
                ? sample.then((result) => {
                    this.waitWrappedSample().then(resolve);
                    return result;
                })
                : resolve();
            });
    },

    /**
     * дождаться всех отдельных попыток запроса, ответы или таймауты на которые в данный момент ожидаются
     *
     * @param  {Boolean} [multi=true] используеться для debounce и multiple метода
     * @return {Promise}
     */
    waitPendingSample: function (multi = true) {
        return new Promise((resolve) => {
            let sample = _.sample(this.allPendingRequests) || (multi && _.sample(this.allMultiPendingRequests));
            return sample
                ? sample.promise.finally(() => {
                    this.waitPendingSample(multi).then(resolve);
                })
                : resolve();
            });
    },

    // забрать зарегистрированные конфиги из буфера и вывести модальное окно с предупреждением по ним
    showWarningModal: _.debounce(function(error, props) {
        if (this.pausePending) return;

        let dialog, blockTimeout = setTimeout(
            () => dialog = ElMessageBox({
                message: 'Waiting for pending requests...',
            }
        ), 300);

        this.pausePending = this.waitPendingSample(false).then(() => {
            let groups = _.uniq(_.flatMap(this.modalWarningBuffer, (warning) => {
                return warning.config && Object.keys(warning.config).length
                    ? (warning.config.groupsMerge
                        ? _.keys(warning.config.groupsMerge)
                        : (warning.config.group || warning.config.object)
                    ) : [];
            }));

            clearTimeout(blockTimeout);
            dialog && dialog.hide();

            let modalWarnings;
            return warningModal(props, {
                customConfirm: (isConfirm) => {
                    // register warnings at the moment of the confirmation so they wont go into infinite loop
                    modalWarnings = this.modalWarningBuffer;
                    this.pausePending = false;
                    this.modalWarningBuffer = [];
                    return isConfirm;
                },

                onCancelOrReject: (result) => {
                    // if return false, attempt promises will say goodbye and hang for ever
                    if (result !== false) {
                        _.each(modalWarnings, (warning) => {
                            warning.reject(warning.error);
                            if (_.has(warning, ['config', 'state'])) {
                                warning.config.state.isLoading = false;
                            }
                        });
                    }
                },

                onConfirmSuccess: (result) => {
                    // if return false, attempt promises will say goodbye and hang for ever
                    if (result !== false) {
                        _.each(modalWarnings, (warning) => {
                            warning.config.attempter(AttemptMode.MANUAL_RETRY).then(warning.resolve).catch(warning.reject);
                        });
                    }
                }
            }, error, groups);
        });
    }, 500),

    // запускает очередь handler'ов на успешных ответах
    responseHandlerChainer: function (response) {
        if (!response || !response.data || !response.request || !response.config) {
            console.error('Malformed http success response! Rejecting...');
            return errorInterceptor({message: 'Malformed http success response', response: response, config: response.config});
        }

        return this.runHandlerChain(response, 'onSuccess', this.responseCallback).then(() => response);
    },

    // запускает очередь handler'ов на ошибках
    exceptionHandlerChainer: function (error) {
        let config = _.get(error, 'config', EmptyConfig);
        let {data, method, url} = config.getProperties();
        let reHandle = false;
        let response = _.get(error, 'response', {data: undefined, config});
        let isTimedOut = error && error.code === 'ECONNABORTED';
        response.describeOperation = `Operation: ${this.describeOperation(method, 'responseException', config)}\n`;
        response.describeResponse = isTimedOut
            ? 'Request timed out due to application failure or connection is lost due to network problems\n'
            : (_.has(error, ['response', 'data'])
                ? `Server response:\n${JSON.stringify(error.response.data, null, '\t')}\n`
                : 'Got empty response or undefined error\n'
            );

        response.describeData = getRequestPayload(config) + `URL: ${url}\n`;
        response.config.setReHandle = (mode = AttemptMode.REHANDLE) => reHandle = mode;

        // если один из handler'ов задаст config.reHandle = true, то будет сделана новая попытка запроса
        return this.runHandlerChain(response, 'onError', this.responseException).then((handlerResult) => {
            // for debugging
            // console.log(`error[${errorGuid}] reHandle`, reHandle);
            if (reHandle !== false) {
                return config.attempter(reHandle, error);
            }
            return Promise.reject(response);
        });
    },

    // обработчик цепочки Promise на запросах
    // регистрирует запрос в стеке, ставит на него handler'ы успеха, неудачи и таймаута
    // возвращает Promise, который будет разрешён в ответ после всех автоматических ретраев, которые произошли,
    // или undefined, если истекло количество попыток
    wrap: function(requestor, data, config, method, url) {
        let wrapper = this;
        let wrapRequest = new WrapRequest(requestor, config, wrapper);
        config.getProperties = function() {
            return {data, method, url};
        };
        // attempter это сущность, которая вызовет запрос, когда очередь запросов по этому объекту будет свободна
        config.attempter = function (mode = AttemptMode.INITIAL_ATTEMPT, error) {
            let attemptConfig = _.get(error, 'config') || config;
            let attemptFunc;
            if (typeof mode === 'function') {
                attemptFunc = mode;
            } else {
                let attemptMode = AttemptModeAction.hasOwnProperty(mode) ? mode : AttemptMode.NOMODE;
                attemptFunc = AttemptModeAction[attemptMode];
            }
            return Promise.resolve(attemptFunc(wrapRequest, error, attemptConfig)).then((result) => {
                return result;
            });
        };

        // вернуть Promise, который зарезолвится тогда, когда пришёл первый успешный ответ из одной или нескольких попыток
        return wrapRequest.wrapper.registerPendingRequest((config) => config.attempter(), config).catch((error) => {
            return this.runHandlerChain(error, 'onAbort').then(() => error);
        });
    }

};

export default api;
