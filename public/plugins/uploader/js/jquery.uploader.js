/*
 * Uploader 1.1, jQuery plugin
 * 
 * Copyright(c) 2011, Samuel De Backer
 * http://www.typi.be
 *	
 * Uploader gives progress bars to html5 input file 
 * with multiple and accept attributes.
 * Thanks to jQuery community 
 * Licenced under the MIT Licence
 */
(function ($){
	
	var settings = {
		directUpload: false,
		maxSize: 8000000,
		dropZone: '',
		url: '',
		maxFiles: '',
		removable: false,
		initialize: function () { },
		allComplete: function (numberOfFiles) { }
	};
	var fileInput;
	var pickFilesBtn;
	var submitBtn;
	var fileList;
	var uploaderForm;
	var dropZone;
	var nbOfFilesToUpload;
	var numberOfFiles;
	var bytesUploaded;
	var bytesTotal;
	var accept;
	var files;
	var chooseFileLabel;
	var emptyQueueLabel;

	var methods = {
		init: function (options) {

			return this.each( function () {
				
				if (options) {
					$.extend(settings, options);
				}

				if ($('html').attr('lang') == 'fr') {
					chooseFileLabel = 'Choisir les fichiers';
					emptyQueueLabel = 'Vider';
				} else {
					chooseFileLabel = 'Choose files';
					emptyQueueLabel = 'Empty queue';
				};
				
				settings.initialize.call(this);
				
				fileInput = $(this);
				fileInput.parent().after($('<ul id="fileList"></ul>'));
				fileInput.css({'visibility':'hidden','position':'absolute'});
				fileInput.before('<a class="btn btn-default btn-sm" id="pickFilesBtn" href="#">' + chooseFileLabel + '</a>');
				pickFilesBtn = $('#pickFilesBtn');
				submitBtn = pickFilesBtn.closest('form').find('button:submit');
				submitBtn.prop('disabled',true).hide();
				fileList = $('#fileList');
				uploaderForm = fileInput.closest('form');
				dropZone = $('#' + settings.dropZone);
				nbOfFilesToUpload = 0;
				numberOfFiles = 0;
				bytesUploaded = 0;
				bytesTotal = 0;
				acceptAttr = fileInput.attr('accept');
				if ( ! acceptAttr) {
					acceptAttr = 'text/*';
				}
				acceptArray = acceptAttr.split(',');
				files = new Object();
				if (settings.url == '') {
					settings.url = uploaderForm.attr('action');
				}
				pickFilesBtn.click(function (e){
					fileInput.trigger('click');
					e.preventDefault();
				});
				uploaderForm.submit(function (e){
					if (settings.directUpload == false) {
						if (files.length) {
							$('.progress-bar').show();
							for (i=0; i < files.length; i += 1) {
								methods.uploadFile(files[i], i);
							}
						} else {
							alert('No file found');
						}
						e.preventDefault();
					}
				});
				if (dropZone.length) {
					dropZone.bind('dragover', function () { $(this).addClass('focus'); return false; })
						.bind("dragleave",function () { $(this).removeClass('focus'); return false; })
						.bind("dragend",function () { $(this).removeClass('focus'); return false; })
						.bind("drop", function (event) {
							files = new Object(); // remettre la liste des fichiers à zéro
							$(this).removeClass("focus");
							event.stopPropagation();
							event.preventDefault();
							for (var prop in event.originalEvent.dataTransfer.files) {
								files[prop] = event.originalEvent.dataTransfer.files[prop];
							}
							if (event.originalEvent.dataTransfer.files.length > 0) {
								methods.handleFiles();
							};
						}
					);
				}

				methods.show();
				
			});
			
		},
		show: function () {

			fileInput.change(function (){
				$('#emptyQueueBtn').remove();
				files = new Object(); // remettre l'objet à zéro
				for (var prop in this.files) {
					if (!files.hasOwnProperty(prop)) {
						files[prop] = this.files[prop];
					}
				}
				methods.handleFiles();
			});

		},
		hide: function () {
			
		},
		update: function (content) {
			
		},
		reset: function (content) {
			pickFilesBtn.show();
			fileInput.replaceWith(fileInput.clone());
			fileInput = $('#fileInput');
			submitBtn.prop('disabled',true).hide();
			files = new Object();
			fileList.find('li').remove();
			methods.show();
			numberOfFiles = 0;
			nbOfFilesToUpload = 0;
			$('#emptyQueueBtn').remove();
		},
		recreateInputFile: function () {
		},
		handleFiles: function () {
			nbOfFilesToUpload = 0;
			if (settings.maxFiles != '' && files.length > settings.maxFiles) {
				alert('Max ' + settings.maxFiles + ' files at a time');
				return;
			}
	
			pickFilesBtn.prop('disabled',true);
			pickFilesBtn.hide();
			fileList.find('li').remove();
	
			var i,l;
			for( i = 0, l = files.length; i < l; i += 1){
				
				var checkType = false;
				$(acceptArray).each(function (index) {
					if (files[i].type.match( new RegExp( $.trim(acceptArray[index]) ) )) {
						checkType = true;
					}
				});
				
				var checkSize = (files[i].size < settings.maxSize) ? true : false ;
		
				if ( checkType && checkSize) {
					var fileSize = 0;
					if (files[i].size > 1024 * 1024) {
						fileSize = (Math.round(files[i].size * 100 / (1024 * 1024)) / 100).toString() + ' MB';
					} else {
						fileSize = (Math.round(files[i].size * 100 / 1024) / 100).toString() + ' KB';
					}
					nbOfFilesToUpload += 1;
					fileList.append('<li id="file-' + i + '"><div class="txt">' + files[i].name + ' (' + fileSize + ')</div><div class="percent"></div><div class="progress progress-info progress-striped active"><div class="progress-bar"></div></div></li>');
					if (settings.removable === true) {
						fileList.children('li').append('<a class="removeFile">×</a>');
					}
					$('.progress-bar').hide();
					if (settings.directUpload == true) {
						methods.uploadFile(files[i], i);
					}
				} else {
					if (!checkType) {
						alert(files[i].name + ' : file type (' + files[i].type + ') not accepted');
					} else if (!checkSize) {
						alert(files[i].name + ' : too big');
					}
					delete files[i];
				}
			}
			if (fileList.find('li').length) {
				fileInput.after(' <a id="emptyQueueBtn" class="btn btn-danger">'+emptyQueueLabel+'</a>');
				$(document).on('click', '#emptyQueueBtn', function(){
					pickFilesBtn.show();
					methods.reset();
				});
				submitBtn.prop('disabled',false).show();
			} else {
				pickFilesBtn.prop('disabled',false);
				pickFilesBtn.show();
			}
			//console.log(files);
			if (settings.removable == true) {
				methods.enableRemoveButton();
			}
		},
		enableRemoveButton: function () {
			$('.removeFile').each(function (index) {
				$(this).bind('click', function (){
					$(this).parent().slideUp(100);
					delete files[index];
				});
			});
		},
		uploadFile: function ( file, i ) {
			if (settings.removable == true) {
				$('.removeFile').remove();
			}
			var fd = new FormData();
			uploaderForm.find('input:not(:file):not(:submit)').each(function (index) {
				fd.append(this.name, this.value);
			});
			fd.append("file[]", file);
				
			var xhr = new XMLHttpRequest();
				
			xhr.upload.addEventListener("progress", function (event) {
				var percentComplete = Math.round(event.loaded * 100 / event.total);
				if (event.lengthComputable) {
					var fichier = $('#fileList li:eq(' + i + ')');
					fichier.find('.progress-bar').css({'width':Math.round(percentComplete).toString() + '%'});
					fichier.find('.percent').html(percentComplete.toString() + ' %');
					if (percentComplete == 100) {
						$('#fileList li:eq(' + i + ') .progress').removeClass('active progress-striped progress-info').addClass('progress-success');
					}
				} else {
					// No data to calculate on
				}
			}, false);
				
			xhr.addEventListener("load", methods.uploadComplete, false);
			xhr.addEventListener("error", methods.uploadFailed, false);
			xhr.addEventListener("abort", methods.uploadCanceled, false);
			xhr.open("POST", settings.url, true);
			xhr.setRequestHeader("Cache-Control", "no-cache");
			xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
			xhr.send(fd);
	
		},
		uploadComplete: function () {
			numberOfFiles += 1;
			if (numberOfFiles == nbOfFilesToUpload) {
				settings.allComplete.call(this, numberOfFiles);
				methods.reset();
			};
		},
		uploadFailed: function () {
			alert("An error occurred while uploading the file.");
		},
		uploadCanceled: function () {
			alert("The upload has been canceled by the user or the browser dropped the connection.");	
		}
		
	};
	
	$.fn.uploader = function (method) { // HTML5 file api infos: http://www.matlus.com/html5-file-upload-with-progress/	
		
		// Method calling logic
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method == 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.uploader');
		}
		
	};
})( jQuery );