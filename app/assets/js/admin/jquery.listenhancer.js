/*
 * ListEnhancer 1.0, jQuery plugin
 * 
 * Copyright(c) 2012, Samuel De Backer
 * http://www.typi.be
 *	
 * ListEnhancer add buttons select-all to lists with checkboxes 
 * and show confirm box (nedd bootbox plugin) when submit.
 * Thanks to jQuery community 
 * Licenced under the MIT Licence
 */
(function($)
{
	var settings = {
		done: function(data) {},
		error: function(jqXHR, textStatus, errorThrown) {}
	};
	var listForm, nbOfCheckboxes, nbOfCheckedCheckboxes, actionName, btnSelectAll, selectAllText, deSelectAllText;
	var translations = {
		'nl': {
			'delete': 'Supprimer',
			'Cancel': 'Annuler',
			'item': 'élément',
		},
		'en': {
			'delete': 'Delete',
			'Cancel': 'Cancel',
			'item': 'item',
		},
		'fr': {
			'delete': 'Supprimer',
			'Cancel': 'Annuler',
			'item': 'élément',
		}
	}
	var lang = $('html').attr('lang');
	var methods = {
		init: function (options) {
			return this.each(function() {				
				if (options) {
					$.extend(settings, options);
				}
				listForm = $(this);
				$(':submit').addClass('custom-alert');
				$(':submit').click(function(){
					actionName = this.name;
				});
				listForm.submit(
					methods.beforeSubmit
				);

				listForm.find('.btn-toolbar button').prop('disabled', true);
				listForm.find('.btn-toolbar').prepend('<div class="btn-group" id="selectAllGroup"></div>');
				btnSelectAll = $('#btn-select-all');
				selectAllText = btnSelectAll.text();
				deSelectAllText = btnSelectAll.data('deselect-text');
				btnSelectAll.click(function(event) {
					//alert($(this).attr('id'));
					$(this).toggleClass('checked');
					var checked_status;
					if ($(this).hasClass('checked')) {
						checked_status = 'checked';
					}
					listForm.find('input:checkbox:not(:disabled)').each(function () {
						this.checked = checked_status;
						if (checked_status) {
							btnSelectAll.text(deSelectAllText);
						} else {
							btnSelectAll.text(selectAllText);
						}
					});
					methods.verifierCheckboxes();
					return false;
				});
				listForm.find(':checkbox').change(function () {
					if (this.checked) {
						methods.checkChilds($(this));
					} else {
						methods.uncheckParents($(this));
					}
					methods.verifierCheckboxes();
				});

			});
		},
		beforeSubmit: function () {
			var confirmString;
			if (nbOfCheckedCheckboxes > 0) {
				if (actionName === 'delete') {
					confirmString = methods.translate(actionName) + ' ' + nbOfCheckedCheckboxes.toString() + ' ' + methods.translate('item');
					if (nbOfCheckedCheckboxes > 1) {
						confirmString += 's';
					}
					confirmString += ' ?';
					bootbox.dialog(confirmString, [{
						label: methods.translate('Cancel')
					}, {
						label: methods.translate(actionName),
						class: 'btn-danger',
						callback: methods.launchAction
					}], {
						header: 'Attention',
						animate: false,
						onEscape: function(){
							$(this).close();
						}
					});
				} else {
					return true;
				}
			}
			return false;
		},
		launchAction: function() {
			listForm.find('.btn-toolbar button').prop('disabled', true);
			var checkedItems = listForm.find('input:checkbox:checked').parent();
			if (actionName === 'delete') {
				var nb_elements = listForm.find('#nb_elements');
				if (nb_elements.html() > '0') {
					nb_elements.html(nb_elements.html() - parseInt(nbOfCheckedCheckboxes, 10));
				}
			};
			$.ajax({
				type: 'POST',
				url: listForm.attr('action'),
				dataType: 'json',
				data: listForm.serialize()+'&'+actionName+'='+actionName,
				success: function (data) {
					settings.done.call(this, data);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					settings.error.call(this, jqXHR, textStatus, errorThrown);
				}
			});
		},
		translate: function(string) {
			return translations[lang][string];
			// return string;
		},
		verifierCheckboxes: function() {
			nbOfCheckboxes = listForm.find('input:checkbox:not(:disabled)').length;
			nbOfCheckedCheckboxes = listForm.find('input:checkbox:checked').length;
			if (nbOfCheckedCheckboxes === 0) {
				listForm.find('.btn-toolbar button').prop('disabled', true);
				btnSelectAll.text(selectAllText).removeClass('checked').prop({'checked': false});
			} else {
				listForm.find('.btn-toolbar button').prop('disabled', false);
				if (nbOfCheckboxes === nbOfCheckedCheckboxes) {
					btnSelectAll.text(deSelectAllText).addClass('checked').prop({'checked': true});
				} else {
					btnSelectAll.text(selectAllText).removeClass('checked').prop({'checked': false});
				}
			}
		},
		checkChilds: function(checkbox) {
			checkbox.closest('li').find('input:checkbox').prop({'checked':'checked'});
		},
		uncheckParents: function(checkbox) {
			checkbox.parents('li').children().children('input:checkbox').prop({'checked':''});
		}

	};
	$.fn.listEnhancer = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method == 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.listEnhancer');
		}
	};
})(jQuery);
