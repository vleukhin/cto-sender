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
    var pattern = /^((\+\d)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{10}$/;
    return pattern.test(phone);
}

function getCookie(name) {

    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ))
    return matches ? decodeURIComponent(matches[1]) : undefined
}

addScript('/sender/js/tooltipster/js/tooltipster.bundle.min.js');
addCss('/sender/js/tooltipster/css/tooltipster.bundle.min.css');

function collect(form, delay) {
    if (!loading) {
        loading = true;

        delay = typeof delay !== 'undefined' ? delay : 0;

        if (!delay) {
            var button = form.find('[type=submit]');
            var text = button.val();
            button.css('min-width', button.css('width'));
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
            note: $('[name=note]', form).val(),
            timezone: 'МСК' + timezone,
            formId: form.attr('id'),
            formData: form.serializeArray(),
            delay: delay,
            roistat_id: getCookie('roistat_visit')
        };

        $.ajax('/sender/send.php', {
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                loading = false;
                if (!delay) {
                    yaMetrikaReachGoal('supercel');

                    button.html(text);
                    button.css('cursor', 'default');

                    if (response.result.collector.success) {
                        trackLead(response.result.collector.transaction_id);
                    }

                    $('.firstBoxItems,.balanceBoxItems').prop('disabled', true);
                    $(location).attr('href', response.redirect);
                }
            }
        });
    }
}

function trackLead(transaction_id) {
    if (typeof dataLayer !== 'undefined') {
        dataLayer.push({
            'ecommerce': {
                'currencyCode': 'RUB',
                'purchase': {
                    'actionField': {
                        'id': transaction_id,
                        'affiliation': 'Landing'
                    },
                    'products': []
                }
            },
            'event': 'gtm-ee-event',
            'gtm-ee-event-category': 'Enhanced Ecommerce',
            'gtm-ee-event-action': 'Purchase',
            'gtm-ee-event-non-interaction': 'False'
        });
    }

    ADMITAD = window.ADMITAD || {};
    ADMITAD.Invoice = ADMITAD.Invoice || {};
    ADMITAD.Invoice.broker = "adm";     // параметр дедупликации (по умолчанию для Admitad)
    ADMITAD.Invoice.category = "1";     // код целевого действия (определяется при интеграции)

    ADMITAD.Invoice.referencesOrder = ADMITAD.Invoice.referencesOrder || [];

    ADMITAD.Invoice.referencesOrder.push({
        orderNumber: transaction_id, // внутренний номер заказа (не более 100 символов)
        orderedItem: []
    });

    if (typeof ADMITAD.Tracking !== 'undefined') {
        ADMITAD.Tracking.processPositions();
    }
}

function trackUser() {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", JSON.parse(xmlHttp.response).url + '/landing/track', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify({
                uid: getUserId(),
            }));
        }
    };

    xmlHttp.open("GET", '/sender/collector.php');
    xmlHttp.send(null);
}

function generateUserId() {
    var S4 = function () {
        return (((1 + Math.random()) * 0x10000) | 0)
            .toString(16)
            .substring(1);
    };

    return (S4() + S4() + S4());
}

function getUserId() {
    let cookie = "cto.uid";
    var id = getCookie(cookie);

    if (!id) {
        id = generateUserId();

        setCookie(cookie, id, 7);
    }

    return id;
}

function getCookie(name) {
    var matches = document.cookie.match(
        new RegExp(
            "(?:^|; )" +
            name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") +
            "=([^;]*)"
        )
    );
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function yaMetrikaReachGoal(goal) {
    console.log('yaMetrikaReachGoal: ' + goal);

    for (var object in window) {
        if (window.hasOwnProperty(object) && object.startsWith('yaCounter')) {
            var counter = window[object];
            counter.reachGoal(goal);
        }
    }
}

function markWhatsAppMessage() {
    var link = $('.whatsapp-button').parent();

    if (link.length){
        var href = new URL(link.attr('href'));
        href.search = href.search.replace(/(\?text=)(.*)/, '$1' + 'Номер вашего обращения: ' + getUserId()  +'. $2');
        link.attr('href', href.toString())
    }
}

(function ($) {
    $(document).ready(function () {
        trackUser();

        markWhatsAppMessage();

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

            if (validPhone(phone)) {
                collect(form, 1)
            }
        });

        body.delegate('form.sform', 'submit', function (event) {
            event.preventDefault();

            collect($(this));
        });
    });
})(window.jQuery);