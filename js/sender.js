/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */
(function ($) {
    $(document).ready(function () {
        $('form').on('submit', function () {
            var geolocation = ymaps.geolocation;
            console.log(geolocation.city);
        })
    });
})(window.jQuery);