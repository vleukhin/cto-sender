/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */
(function ($) {
    $(document).ready(function () {
        $('form').on('submit', function (event) {
            event.preventDefault();

            var form = $(this);

            var timezone = -(new Date().getTimezoneOffset()) / 60 - 3;

            if (timezone > 0){
                timezone = '+' + timezone
            }
            else{
                timezone = '-' + timezone
            }

            var data = {
                city: ymaps.geolocation.city,
                name: $('[name=name]', form).val(),
                phone: $('[name=phone]', form).val(),
                email: $('[name=email]', form).val(),
                comment: $('[name=subject]', form).val(),
                timezone: 'МСК' + timezone
            };

            $.ajax('/sender/send.php', {
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    var urlCto = 'http://mtraktor.ru/o-kompanii';
                    $('form').trigger('reset');

                    ga('send', 'event', 'Knopka', 'cel1');

                    setTimeout($(location).attr('href', urlCto), 7000);
                    //echo
                    location.href = '#close';
                    location.href = '#openModalOk';
                    $('.firstBoxItems,.balanceBoxItems').prop('disabled', true);
                    // setTimeout(location.href='#close', 5000);
                }
            });
        })
    });
})(window.jQuery);