/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */
(function ($) {
    $(document).ready(function () {
        var loading = false;
        $('body').delegate('form.sform', 'submit', function (event) {
            event.preventDefault();

            if (!loading) {
                loading = true;

                var form = $(this);
                var button = form.find('[type=submit]');
                var text = button.val();
                button.css('width', button.css('width'));
                button.css('cursor', 'not-allowed');
                button.val('Подождите...');

                var timezone = -(new Date().getTimezoneOffset()) / 60 - 3;
                var sign = timezone < 0 ? '-' : '+';
                timezone = sign + timezone;

                var data = {
                    city: ymaps.geolocation.city,
                    name: $('[name=name]', form).val(),
                    phone: $('[name=phone]', form).val(),
                    email: $('[name=email]', form).val(),
                    comment: $('[name=subject]', form).val(),
                    timezone: 'МСК' + timezone,
                    formId: form.attr('id'),
                    formData: form.serializeArray()
                };

                $.ajax('/sender/send.php', {
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        button.html(text);
                        button.css('cursor', 'default');

                        console.log(response);
                        $('form').trigger('reset');

                        setTimeout(function () {
                            $(location).attr('href', response.redirect);
                        }, 4000);

                        location.href = '#close';
                        location.href = '#openModalOk';
                        $('.firstBoxItems,.balanceBoxItems').prop('disabled', true);
                    }
                });
            }
        })
    });
})(window.jQuery);