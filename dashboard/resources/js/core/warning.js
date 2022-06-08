import { ElMessageBox } from 'element-plus';
import { tap, guid } from '../core/helper.js';

const boundResolve = Promise.resolve.bind(Promise);
const DEFAULT_CONFIRM_OPTION = {
    modalCallback: boundResolve,
    customConfirm: boundResolve,
    onCancelOrReject: boundResolve,
    onConfirmSuccess: boundResolve,
};

/**
 * Create DOM tree for error description
 *
 * @param {Object} param
 * @param {String} param.errorText
 * @param {Number} param.rows
 * @returns DocumentFragment
 */
export const createErrorDescriptionDOM = function(param) {
    return tap(document.createDocumentFragment(), (descriptionFragment) => {
        if (param.descriptionText) {
            descriptionFragment.appendChild(tap(document.createElement('p'), (descriptionParagraphEl) => {
                descriptionParagraphEl.appendChild(document.createTextNode(param.descriptionText));
            }));
        }

        if (param.errorText) {
            if (param.pleaseCopy) {
                descriptionFragment.appendChild(tap(document.createElement('p'), (pleaseCopyParagraphEl) => {
                    pleaseCopyParagraphEl.appendChild(document.createTextNode(
                        'Please, copy the text below and send it to the platform_optimization to help us find the cause of the problem.'
                    ));
                }));
            }

            descriptionFragment.appendChild(tap(document.createElement('textarea'), (descriptionTextAreaEl) => {
                descriptionTextAreaEl.setAttribute('readonly', 'readonly');
                descriptionTextAreaEl.setAttribute('class', 'uk-textarea backtrace-area');
                descriptionTextAreaEl.setAttribute('rows', param.rows || 12);
                descriptionTextAreaEl.appendChild(document.createTextNode(param.errorText));
            }));
        }
    });
};

/**
 * get description text note
 *
 * @param  {Text} text [description text]
 * @return {TextNode}
 */
export const getDescriptionEl = function(text) {
    let descriptionEl = text || `Oops! Something unknown was happened and we were unable to save field change.
    The field value in DB will probably retain its original value. Unsaved field(s):`;

    if (typeof descriptionEl === 'string') {
        descriptionEl = document.createTextNode(descriptionEl);
    }

    return descriptionEl;
};

/**
 * Append meta info to document element
 *
 * @param  {NodeElement} element
 * @param  {Object} error
 * @param  {Array} groups
 * @return {void}
 */
export const appendRequestMetaInfo = function(element, error, groups) {
    let detailsCode = _.get(error, ['response', 'data', 'data', 'code']);
    let code = _.get(error, ['response', 'data', 'code']);
    let errorCode = detailsCode ? `${code}::${detailsCode}` : code;
    // list of groups for retry
    element.appendChild(tap(document.createElement('ul'), (groupsList) => {
        groups.forEach((group) => {
            groupsList.appendChild(tap(document.createElement('li'), (listItem) => {
                listItem.appendChild(document.createTextNode(group));
            }));
        });
    }));

    // error code block
    element.appendChild(tap(document.createElement('div'), (codeBlockEl) => {
        codeBlockEl.appendChild(tap(document.createElement('strong'), (codeBlockStrongEl) => {
            codeBlockStrongEl.appendChild(document.createTextNode('Code'));
        }));

        codeBlockEl.appendChild(document.createTextNode(': '));
        codeBlockEl.appendChild(tap(document.createElement('tt'), (codeBlockErrorCodeEl) => {
            codeBlockErrorCodeEl.setAttribute('class', 'uk-text-danger');
            codeBlockErrorCodeEl.appendChild(document.createTextNode(errorCode || '-'));
        }));
    }));
};

/**
 * Get tree with the warning text for the modal window
 *
 * @param {Object} error
 * @param {String, Number} error.response.data.code
 * @param {String, Number} error.response.data.data.code
 *
 * @param {Array} groups
 *
 * @param {Object} props
 * @param {String} props.description
 * @param {String} props.title
 * @param {String} props.icon
 * @param {String} props.className
 *
 * @returns DocumentFragment
 */
export const getRequestWarningText = function(error, groups, props = {}) {
    let parts = [];
    let {appendMeta = true} = props;
    parts.push(tap(document.createElement('div'), (warningEl) => {
        warningEl.setAttribute('class', `tm-modal-message-warning ${props.className || ''}`);
        // error description
        warningEl.appendChild(getDescriptionEl(props.description));
        if (appendMeta) {
            appendRequestMetaInfo(warningEl, error, groups);
        }
    }).outerHTML);
    return parts.join('');
};

/**
 * Display a nice explaination for a user of what the hell of weird shit has just happened with the application
 *
 * @param {Object} props
 * @param {String} props.modal
 * @param {Object} props.labels
 * @param {String} props.labels.ok
 * @param {String} props.labels.cancel
 * @param {Function} props.onConfirm
 * @param {Function} props.onCancel
 * @param {String} props.description
 * @param {String} props.title
 * @param {String} props.icon
 * @param {String} props.className
 *
 * @param {Object} confirmOption
 * @param {Function} confirmOption.modalCallback
 * @param {Function} confirmOption.customConfirm
 * @param {Function} confirmOption.onConfirmSuccess
 * @param {Function} confirmOption.onCancelOrReject
 *
 * @param {Object} error
 * @param {String, Number} error.response.data.code
 * @param {String, Number} error.response.data.data.code
 *
 * @param {Array} groups
 *
 * @returns DocumentFragment
 */
export const warningModal = function (props, confirmOption = {}, error = {}, groups = []) {
    confirmOption = _.extend(DEFAULT_CONFIRM_OPTION, confirmOption);
    props.labels = props.labels || {ok: 'Retry', cancel: 'Cancel'};

    let modal = ElMessageBox[props.modal || 'confirm'](getRequestWarningText(error, groups, props), props.title, {
        dangerouslyUseHTMLString: true,
    });

    // TODO need refactoring
    return confirmOption.modalCallback(modal)
        .then(() => true, () => false)
        .then(confirmOption.customConfirm)
        .then((isConfirm) => {
            if (isConfirm) {
                return Promise.resolve(props.onConfirm && props.onConfirm())
                    .then(confirmOption.onConfirmSuccess)
                    .catch(confirmOption.onCancelOrReject);
            } else {
                return Promise.resolve(props.onCancel && props.onCancel())
                    .then(confirmOption.onCancelOrReject);
            }
        });
};

/**
 * Wrapper for confirm modal
 *
 * @param  {String} text [text description]
 * @return {Promise}
 */
export const confirmModal = function(text, labels = {ok: 'OK', cancel: 'Cancel'}) {
    return warningModal({
        title: 'Attention!',
        description: text,
        labels,
        appendMeta: false,
        onConfirm: () => {
            return true;
        },
        onCancel: () => {
            return false;
        },
    });
};
