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

		var dropZoneTemplate = '<div class="thumbnail dz-preview dz-file-preview">\
				<div class="dz-details">\
					<img data-dz-thumbnail src="" alt="">\
					<div class="caption">\
						<div data-dz-name></div>\
						<div data-dz-size></div>\
						<div class="dz-error-message"><span data-dz-errormessage></span></div>\
					</div>\
				</div>\
				<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\
			</div>';

		$('#uploaderAddButtonContainer').click(function(event) {
			return false;
		});
		$( "#uploaderAddButton" ).on( "click", function() {
			$('#dropzone').trigger('click');
		});

		Dropzone.options.dropzone = {
			clickable: true,
			maxFilesize: 2, // MB
			acceptedFiles: 'image/jpeg,image/gif,image/png',
			previewTemplate: dropZoneTemplate,
			previewsContainer: '.dropzone-previews',
			init: function () {
				var totalFiles = 0,
					completeFiles = 0;
				this.on("complete", function (file) {
					completeFiles += 1;
					if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
						// Mettre à jour les position
						var files = this.getAcceptedFiles();
						var done = 0;
						for (var key in files){
							var object = jQuery.parseJSON( files[key].xhr.responseText );
							object.position = parseInt(object.position) + parseInt(key);
							$.ajax({
								type: 'PATCH',
								url: cleanUrl() + '/' + object.id,
								data: object
							}).done(function(){
								done += 1;
								if (done === files.length) {
									location.reload();
								}
							}).fail(function () {
								alertify.error(translate('An error occurred while sorting files.'));
							});
						}
					}
				});
			}
		};

	});

}( window.jQuery || window.ender );
