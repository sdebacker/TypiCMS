var lang = $('html').attr('lang'),
	langues = ['fr', 'nl', 'en'],
	content = [];

function translate(string) {
	// alert(string);
	// alert('content[string]' + content[string]);
	// return string; // BUG
	// if (content[string]) {
	// 	return content[string];
	// } else {
	// 	return string;
	// }
		return string;
}

function showMessage(responsetext, responsetype) {
	var errorClass;
	if (responsetype == 'error') {
		errorClass = ' alert-error';
	} else {
		errorClass = '';
	}
	$('.alert').remove();
	var alerte = '<p class="alert'+errorClass+'">'+responsetext+'</p>';
	$('#container').prepend(alerte);
	$('.alert').hide().fadeIn('fast');
}

!function( $ ){

	"use strict";

	$(function () {


		function javascriptError(data, statusText) {
			showMessage(translate('Unknown error'), 1);
			console.log(statusText);
			console.log(data);
		}


		function checkAndShowMessageDiv() {
			var messageDiv, error;
			messageDiv = $('#message');
			if (messageDiv.length) {
				messageDiv.hide().children('li').each(function () {
					if ($(this).hasClass('error')) {
						error = 'error';
					}
					showMessage($(this).text(), error);
				});
			}
		}

		checkAndShowMessageDiv();

		// $('#uploader .fileInput').uploader({
		// 	dropZone: 'uploader',
		// 	allComplete: function (number) {
		// 		alertify.success(number + ' ' + translate('files uploaded'));
		// 	},
		// 	error: function (message) {
		// 		alertify.error(message);
		// 	}
		// });

	});

}( window.jQuery || window.ender );
