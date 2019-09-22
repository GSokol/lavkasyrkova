$(document).ready(function ($) {
    ymaps.ready(function () {
        if ($('#map').length) addMap(window.map,'map');
    });
});

function addMap(coords, container) {
    ymaps.ready(function () {
        var myMap = new ymaps.Map(container, {
            center: coords[0].coords,
            zoom: 12,
            controls: ['zoomControl', 'fullscreenControl']
        });

        myMap.behaviors.disable('scrollZoom');

        $.each(coords, function (k,office) {
            myMap.geoObjects
                .add(new ymaps.Placemark(office.coords, {
                    iconContent: office.address
                }, {
                    preset: 'islands#darkgreenStretchyIcon'
                }));
        });


        // myMap.events.add(['click', 'wheel', 'boundschange'], function (e) {
        //     mapAction();
        // });

        // myMap.geoObjects.events.add('click', function (e) {
        //     // Получение ссылки на дочерний объект, на котором произошло событие.
        // });
    });


//     // Задаём точки мультимаршрута.
//     var multiRoute = new ymaps.multiRouter.MultiRoute({
//         referencePoints: [
//             pointA,
//             pointB
//         ],
//         params: {
//             //Тип маршрутизации - пешеходная маршрутизация.
//             routingMode: 'pedestrian'
//         }
//     }, {
//         // Автоматически устанавливать границы карты так, чтобы маршрут был виден целиком.
//         boundsAutoApply: true,
//         // Внешний вид путевых точек.
//         wayPointStartIconColor: "#333",
//         wayPointStartIconFillColor: "#B3B3B3",
//         // Задаем собственную картинку для последней путевой точки.
//         wayPointFinishIconLayout: "default#image",
//         wayPointFinishIconImageHref: "/images/logo_map.png",
//         wayPointFinishIconImageSize: [30, 30],
//         wayPointFinishIconImageOffset: [-15, -15]
//     });
//
//     var myMap = new ymaps.Map(container, {
//         center: pointB,
//         zoom: 12
//     });
//
//     // Добавляем мультимаршрут на карту.
//     myMap.geoObjects.add(multiRoute);
//
//     myMap.events.add(['click', 'wheel', 'boundschange'], function (e) {
//         // mapAction();
//     });
//
//     // myMap.geoObjects.events.add('click', function (e) {
//     //     // Получение ссылки на дочерний объект, на котором произошло событие.
//     //     var object = e.get('target');
//     // });
}