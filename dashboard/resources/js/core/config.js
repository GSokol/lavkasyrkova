import { createApp } from 'vue';

const app = createApp();

app.config.debug = true;
app.config.compilerOptions.whitespace = 'preserve';
// должен ли Vue позволять Vue-devtools проводить инспекцию
// TODO vue3 deprecated
// app.config.devtools = true;
// Устанавливает обработчик для ошибок, не пойманных во время рендеринга компонентов и в наблюдателях. Обработчик получит в параметрах ошибку и действующий экземпляр Vue.
app.config.errorHandler = function (err, vm, info) {
    // обработка ошибки
    // `info` это информация Vue-специфичной ошибки, например в каком хуке жизненного цикла
    // была найдена ошибка. Доступно только в версиях 2.2.0+
    console.error(err);
    console.log(vm);
    console.log(info);
};
// Назначает пользовательский обработчик предупреждений Vue во время выполнения
app.config.warnHandler = function (msg, vm, trace) {
    console.log(msg);
    console.log(trace);
    // `trace` — это трассировка иерархии компонентов
};

window.onerror = function(message, url, line, column, error) {
    console.log(url, line, column, message);
    console.log(error);
};

window.addEventListener('unhandledrejection', function(event) {
    console.log('unhandledrejection:', event);
    //handle error here
    //event.promise contains the promise object
    //event.reason contains the reason for the rejection
});
