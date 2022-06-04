// создать функцию исполнения операции operation
// которая запускает operation, но не чаще чем задержка delay
// и не раньше, чем завершился прошлый вызов operation
// и в случае ожидания исполнения operation все последующие попытки объединяет в одну
// и возвращает promise на текущую попытку
//
// если operation завершила своё последнее выполнение никогда или больше чем delay миллисекунд назад,
// то операция будет выполнена немедленно
//
// если operation завершила своё последнее выполнение меньше, чем delay миллисекунд назад,
// следующее выполнение и любые дополнительные запросы на него в течение delay будут отложены на оставшуюся часть delay
//
// этот хелпер отличается от Promise тем, что задаёт минимальный интервал запусков
// этот хелпер отличается от _.debounce тем, что обязательно ожидает завершения последней запущенной операции
//
// flush возвращает Promise на последнюю запланированную операцию и убирает ожидание timeout по ней
export function debouncePromise(operation, delay = 0) {
    let calledFirst = false;
    let calledAgain = false;
    let afterCalledFirst;
    let firstResultPromise;
    let delayer;
    let flush = function() {};

    if (delay === 0) {
        delayer = (...results) => {
            return Promise.resolve(...results);
        };
    } else {
        delayer = (...results) => {
            // сохраняет resolve от Promise на таймер.
            // при вызове этого резолв будет запущен последний Promise на операцию
            let deferred;
            // запоминаем id таймера чтобы можно было отменить ожидание
            // и немедленно запустить последний Promise на операцию
            let timerId;
            let promise = new Promise((resolve) => {
                deferred = resolve;
                timerId = setTimeout(() => {
                    deferred = undefined;
                    timerId = undefined;
                    resolve(...results);
                }, delay);
            });
            // реализуем свой аналог lodash debounce flush который работает с Promise
            // при вызове немедленно запустит последний ожидающий в очереди Promise
            // но только если он ждет timeout, иначе запустить после предыдущего Promise в очереди
            flush = function() {
                if (timerId) {
                    clearTimeout(timerId);
                    deferred(...results);
                }
            };
            return promise;
        };
    }

   // function is re-used inside itself - but asyncronously, not recursively
   function executor(bound, args) {
      if (calledFirst === false) {
          // on the first call execute immediately and make any next call considered first repeat
          calledAgain = false;

          // remember the unmodified result promise which doesn't have throttling delay
          firstResultPromise = Promise.resolve(operation.apply(bound, args));

          // after the execution place a delay so next calls within that delay will have to wait for it
          calledFirst = firstResultPromise.then(delayer);

          // after the first call resolved, make the next call first again
          afterCalledFirst = calledFirst.then(() => {
              calledFirst = false;
          });

          // on the first call return the promise without delay on it
          return firstResultPromise;
      } else if (calledAgain === false) {
          // it is not the first call and the first call is not yet resolved, but it is the first repeat
          // we need to make sure we won't lose it, and that we won't repeat two calls instead of one
          // so we set calledAgain and the next repeats will just return the first repeat promise again

          // after the first call is resolved, we call the executor again, thus first repeated call will become first call
          calledAgain = afterCalledFirst.then(() => executor(bound, args));
      }

      // otherwise it is a repeat, but not the first one - return the promise of the first repeat
      return calledAgain;
    };

    let executable = function(...args) {
        let bound = this;
        return executor(bound, args);
    };

    executable.flush = function() {
        flush();
        return calledAgain || afterCalledFirst;
    };

    return executable;
};

// первый символ в верхнем регистре
export function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// generate guid
export function guid() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
};

String.prototype.str_replace = function(find, replace) {
    var replaceString = this;
    var regex;
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], "g");
        replaceString = replaceString.replace(regex, replace[i]);
    }
    return replaceString;
};

export function tap(argument, callback) {
    callback(argument);
    return argument;
};

export default {

}
