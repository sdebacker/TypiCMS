var lang = $('html').attr('lang'),
	langues = ['fr', 'nl', 'en'];

!function( $ ){

	"use strict";

	$(function () {

		function initDatepicker() {
			// Boite de sélection de date
			if ($('.datepicker').length) {
				$('.datepicker').datepicker({
					language: lang,
					format: 'dd.mm.yyyy',
					autoclose: true,
					weekStart: 1
				});
			};
		}

		function reloadPage() {
			// console.log('reload page');
			var url,
				container,
				formClass;
			url = window.location.href;
			container = $('#content .formContainer');
			if (container.length) {
				formClass = 'listForm';
				if (container.find('form').hasClass(formClass)) {
					container.load(url + ' .listForm', function () {
						initialize();
					});
				}
			}
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

		function initializeUploader() {
			$('#fileInput').uploader({
				dropZone: 'uploader',
				allComplete: function (number) {
					reloadPage();
					showMessage(number + ' ' + translate('files uploaded'), 0);
				}
			});
		}

		function initialize() {

			var attachments= $('#attachmentsList'),
				mainList = $('.listForm>ul');

			enableSortable();
			initListForm();
			$('form.listForm').listEnhancer({
				done: function(data) {
					reloadPage();
				},
				error: function() {
					reloadPage();
				}
			});

			if ( ! attachments.length) {
				// si on n’est pas dans le cas d’une liste d’attachements
				mainList.nestedCookie();
				setOnlineSwitches(mainList);
			}

			if ($('#menu_langue').length) {
				foutreLesTabs();
			}
			initTextEditor();
			//alert('initialize ' + list.attr('id'));
		}

		function setOnlineSwitches(list) {
			// var startTime = new Date().getTime();
			//alert('setOnlineSwitches on list #' + list.attr('id'));
			var switches = list.find('.switch');
			switches.css({'cursor': 'pointer'}).addClass('js');
			switches.click(function () {
				var liElement = $(this).closest('li'),
					id = liElement.find('input:checkbox').val(),
					status = 'online',
					url;
				if (liElement.hasClass('online')) {
					status = 'offline';
				}
				url = id + '/' + status;
				liElement.toggleClass('online offline');
				$.ajax({
					url: url,
					type: 'POST',
					dataType: 'json',
					data: { action: status, id: id }
				}).done(function (msg) {
					showMessage(msg.responsetext, msg.responsetype);
				}).fail(function () {
					javascriptError();
				});
				return false;
			});
			// var endTime = new Date().getTime();
			// var totalTime = (endTime-startTime);
			// console.log('setOnlineSwitches takes ' + totalTime + ' milliseconds to execute');
		}

		function javascriptError(data, statusText) {
			showMessage(translate('Unknown error'), 1);
			console.log(statusText);
			console.log(data);
		}

		function translate(string) {
			// alert(string);
			// alert('content[string]' + content[string]);
			// return string; // BUG
			if (content[string]) {
				return content[string];
			} else {
				return string;
			}
		}

		function enableSortable() {
			// Sorting avec imbrication
			var sortableList = $('.sortable'),
				maxLevels = 1,
				isTree = false;
			if (sortableList.hasClass('nested')) {
				maxLevels = 3;
				isTree = true;
				sortableList.find('li div').prepend('<span class="disclose"></span>');
			}
			var sortableOptions = {
				forcePlaceholderSize: true,
				handle: 'div',
				cancel: 'input, .label, .attachments a, .switch, .mjs-nestedSortable-branch .disclose',
				helper: 'clone',
				// distance: 2,
				items: 'li',
				opacity: .6,
				placeholder: 'placeholder',
				revert: 250,
				tabSize: 25,
				tolerance: 'pointer',
				toleranceElement: '> div',
				maxLevels: maxLevels,
				listType: 'ul',
				isTree: isTree,
				expandOnHover: 700,
				startCollapsed: false,
				update: function(event, ui) {
					var serializedDatas;
					if (isTree) {
						serializedDatas = sortableList.nestedSortable('serialize');
						serializedDatas += '&nested=true';
					} else {
						serializedDatas = sortableList.sortable('serialize');
					}
					// console.log(serializedDatas);
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: 'reorder',
						data: serializedDatas
					}).done(function (msg) {
						showMessage(msg.responsetext, msg.responsetype);
					}).fail(function () {
						showMessage(translate('An error occurred'), 'error');
						reloadPage();
					});
				}
			};
			if (isTree) {
				sortableList.nestedSortable(sortableOptions);
			} else {
				sortableList.sortable(sortableOptions);
			}
		}

		/*
		** Ajaxifier les listes (delete, online, offline)
		*/
		function initListForm() {
			// console.log('initListForm');
			var listForm, idPageActive, button_action;
			listForm = $('#content').find('form.listForm');
			idPageActive = $('#id_element').val();
			// console.log('tableName : ' + tableName)
			button_action = $('<input>', {
				type: 'hidden',
				id: 'button_action',
				name: '',
				val: '0'
			}).prependTo(listForm);

			$('button:submit').click(function () {
				button_action.attr('name', this.name).val(1);
			});

			listForm.submit(function () {
				$.ajax({
					type: 'POST',
					url: this.action,
					dataType: 'json',
					data: $(this).serialize(),
					beforeSend: function () {
						var elementsATraiter, nombreElementsSelectionnes, confirmString, nb_elements;
						elementsATraiter = listForm.find('input:checkbox:checked').parent();
						//console.log(elementsATraiter);
						nombreElementsSelectionnes = elementsATraiter.length;
						//console.log(nombreElementsSelectionnes);
						if (nombreElementsSelectionnes > 0) {
							if (button_action.attr('name') === 'action[delete]') {
								confirmString = translate('q delete items 1') + ' ' + nombreElementsSelectionnes.toString() + ' ' + translate('q delete items 2');
								if (nombreElementsSelectionnes > 1) {
									confirmString += 's';
								}
								confirmString += '?';
								if (confirm(confirmString)) {
									listForm.find('input:submit').prop('disabled', true);
									elementsATraiter.each(function () {
										$(this).slideUp('fast', function () {
											$(this).remove();
										});
									});
									nb_elements = $(this).find('#nb_elements');
									if (nb_elements.html() > '0') {
										nb_elements.html(nb_elements.html() - parseInt(nombreElementsSelectionnes, 10));
									}
								} else {
									return false;
								}
							}
						} else {
							showMessage(translate('No item selected'), true);
							return false;
						}
					},
					success: function (data) {
						if (data) {
							reloadPage();
							showMessage(data.responsetext, data.responsetype);
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						showMessage(errorThrown.responsetext, errorThrown.responsetype);
					}
				});
				return false;
			});
		}

		function foutreLesTabs() {
			var selectedLangue;
			if ($('input[name=langue_active]').val()) {
				selectedLangue = $('input[name=langue_active]').val();
			} else {
				selectedLangue = lang;
			}
			$('#menu_langue li').each(function(){
				if ($(this).children('a').attr('href') == '#'+selectedLangue) {
					$(this).addClass('active');
				}
			});
		}

		function initPannels() {
			var panels = '.optionPanel:not(.sendFilesFieldset, .open) h4';
			$(panels).css({'cursor': 'pointer'}).click(function () {
				$(this).next().slideToggle();
			}).next().hide();
			$('.showLanguage:checked').closest('p').next().hide();
			$('.showLanguage').click(function () {
				$(this).closest('p').next().slideToggle();
			});
			$('#display ul').each(function () {
				var nbElements, height, margin;
				nbElements = $(this).prev().prev().val();
				height = nbElements * 26;

				if (nbElements > $(this).children().size()) {
					height = $(this).children().size() * 26;
				} else {
					height = nbElements * 26;
				}

				if (nbElements === 0) {
					margin = '0';
				} else if (nbElements > 0) {
					margin = '9px 0 18px';
				}

				$(this).show();
				$(this).css({'height': height.toString() + 'px', 'margin': margin, 'overflow': 'hidden'});
			});
		}

		function traiterCheckboxesDroitsUtilisateurs() {
			var firstInput, autresInput;
			firstInput = $('input[name="pages[]"]:first');
			if (firstInput.length) {
				autresInput = $('input:checkbox:not(:first)');
				if (firstInput.prop('checked')) {
					autresInput.parent().hide();
				}
				firstInput.live('click', function () {
					if (!this.checked) {
						autresInput.parent().show('fast');
					} else {
						autresInput.parent().hide('fast');
					}
				});
			}
		}

		function initDatePicker() {
			// var chooseLabel = translate('Choose');
			var chooseLabel = 'Choisir';
			// $('.datepicker').datepicker({
			// dateFormat: 'dd/mm/yy',
			// showAnim: 'fadeIn',
			// speed: 'fast',
			// showOn: 'button',
			// buttonText: chooseLabel,
			// });
		}

		function initTextEditor() {
			if ( ! navigator.userAgent.match(/iPhone/i) && !navigator.userAgent.match(/iPod/i) && ! webAppTest) {
				var i;
				for (i = langues.length - 1; i >= 0; i -= 1) {
					initTinymce('#editor_' + langues[i]);
				}
			}
		}

		var isGeocoded = false;
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

		function initAddressForm() {
			var form = $('#address').closest('form');
			form.submit(function(event) {
				if (!isGeocoded) {
					var address = [$('#rue').val(),$('#numero').val(),$('#codepostal').val(),$('#localite').val()+', '+$('#pays').val()];
					var addressString = address.join(' ');
					getGeocoderFromAddress(addressString, submitAdressForm);
					return false;
				} else {
					return true;
				}
			});
		}

		function submitAdressForm() {
			var form = $('#address').closest('form');
			form.submit();
		}

		function getGeocoderFromAddress(address, callback) {
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode({
				'address': address
			},
			function(results, status) {
				if(status == google.maps.GeocoderStatus.OK) {
					$('#latitude').attr('value',results[0].geometry.location.lat());
					$('#longitude').attr('value',results[0].geometry.location.lng());
					// console.log(results[0].geometry.location);
					// return false;
					// showMapForLocation(results[0].geometry.location);
					isGeocoded = true;
					callback();
				} else {
					isGeocoded = true;
					callback();
					// alert('Impossible de trouver la position de l’adresse entrée.');
				}
			});
		}

		function showMapForLocation(myLocation) {
			$('#address div').append('<div id="map"></div>');
			$('#map').css({'margin-bottom':'10px','height':'300px','width':'auto'});
			var mapOptions = {
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: myLocation,
				zoom: 15
			};
			var map = new google.maps.Map(document.getElementById("map"), mapOptions);
			new google.maps.Marker({
				position: myLocation,
				map: map
			});
		}

		$('#display input').keyup(function () {
			var nbElements, height, margin;
			nbElements = $(this).val();
			height = nbElements * 26;

			if (nbElements > $(this).next().next('ul').children().size()) {
				height = $(this).next().next('ul').children().size() * 26;
			} else {
				height = nbElements * 26;
			}

			if (isNaN(nbElements) || $(this).next().next('ul').children().size() === 0) {
				margin = '0';
				height = 0;
				$(this).val(0);
			} else if (!isNaN(nbElements)) {
				if (nbElements === 0) {
					margin = '0';
				} else if (nbElements > 0) {
					margin = '9px 0 18px';
				}
			}

			$(this).next().next('ul').animate({'height': height.toString() + 'px', 'margin': margin}, 500);
		});

		$('input[autofocus="autofocus"]').focus();

		// $.getJSON('/admin/langues/' + lang + '.php?forJS=1', function (data) { // charger les contenus texte puis initialiser.
		// 	content = data;
		// 	initialize();
		// });
		// initialize();

		// $('.btns.bottom input').clone().appendTo('form').wrap('<p class="submit"></p>');

		initAddressForm();
		traiterCheckboxesDroitsUtilisateurs();
		initPannels();
		initDatePicker();
		checkAndShowMessageDiv();
		// initializeUploader();

	});

}( window.jQuery || window.ender );
