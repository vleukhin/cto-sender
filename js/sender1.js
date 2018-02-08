/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */
var loading = false;

function collect(form, delay) {
	if (!loading) {
		loading = true;

		delay = typeof delay !== 'undefined' ? delay : false;

		if (!delay){
			var button = form.find('[type=submit]');
			var text = button.val();
			button.css('width', button.css('width'));
			button.css('cursor', 'not-allowed');
			button.val('Подождите...');
		}

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
	    $('body').delegate('form.sform [name=phone]', 'keyup', function (event) {
	        var phone = $(this).val();
	        var form = $(this).closest('form');

            if (validPhone(phone)){
                collect(form, true)
            }
	    });

        $('body').delegate('form.sform', 'submit', function (event) {
	        event.preventDefault();

	        collect($(this));
        });
    });
})(window.jQuery);