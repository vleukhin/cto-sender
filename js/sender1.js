/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */
var loading = false;

function addScript(src) {
    var s = document.createElement('script');
    s.setAttribute('src', src);
    document.head.appendChild(s);
}

function addCss(src) {
    var css = document.createElement('link');
    css.href = src;
    css.type = "text/css";
    css.rel = "stylesheet";
    css.media = "screen,print";
    document.head.appendChild(css);
}

function validPhone(phone) {
    var pattern = /^((8|\+7|7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{10}$/;
    return pattern.test(phone);
}

addScript('/sender/js/tooltipster/js/tooltipster.bundle.min.js');
addCss('/sender/js/tooltipster/css/tooltipster.bundle.min.css');

function collect(form, delay) {
    if (!loading) {
        loading = true;

        delay = typeof delay !== 'undefined' ? delay : 0;

        if (!delay){
            var button = form.find('[type=submit]');
            var text = button.val();
            button.css('width', button.css('width'));
            button.css('cursor', 'not-allowed');
            button.val('Подождите...');
        }

        var timezone = -(new Date().getTimezoneOffset()) / 60 - 3;
        var sign = timezone < 0 ? '' : '+';
        timezone = sign + timezone;

        var data = {
            city: ymaps.geolocation.city,
            name: $('[name=name]', form).val(),
            phone: $('[name=phone]', form).val(),
            email: $('[name=email]', form).val(),
            comment: $('[name=subject]', form).val(),
            timezone: 'МСК' + timezone,
            formId: form.attr('id'),
            formData: form.serializeArray(),
            delay: delay
        };

        $.ajax('/sender/send.php', {
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                loading = false;
                if (!delay){
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
            }
        });
    }
}

(function ($) {
    $(document).ready(function () {
        $(".phone-mask").mask("0 (000) 000-00-00", {placeholder: "_ (___) ___-__-__"});

        var body = $('body');

        body.delegate('[type="submit"]', 'click', function () {
            var form = $(this).closest('form');
            var field = form.find('[name=phone]');
            var phone = field.val();

            if (!validPhone(phone)) {
                field.attr('title', 'Номер введен некорректно!');

                if (!field.hasClass('tooltipstered')) {
                    field.tooltipster();
                }

                field.tooltipster('open');
                field.focus();

                return false;
            }

            return true;
        });

	    body.delegate('form.sform [name=phone]', 'keyup', function (event) {
	        var phone = $(this).val();
	        var form = $(this).closest('form');

            if (validPhone(phone)){
                collect(form, 1)
            }
	    });

        body.delegate('form.sform', 'submit', function (event) {
	        event.preventDefault();

	        collect($(this));
        });
    });
})(window.jQuery);