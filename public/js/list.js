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
		cancel: 'input, .label, .attachments a, .mjs-nestedSortable-branch .disclose',
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
			var serializedDatas,
				elementId = ui.item.attr('id').split(/[_]+/).pop();
			if (isTree) {
				serializedDatas = sortableList.nestedSortable('serialize');
				serializedDatas += '&nested=true&moved=' + elementId;
			} else {
				serializedDatas = sortableList.sortable('serialize');
			}
			// console.log(serializedDatas);
			$.ajax({
				type: 'POST',
				url: document.URL.split('?')[0] + '/sort',
				data: serializedDatas
			}).fail(function () {
				alertify.error(translate('An error occurred'));
			});
		}
	};
	if (isTree) {
		sortableList.nestedSortable(sortableOptions);
	} else {
		sortableList.sortable(sortableOptions);
	}
}

/**
 * Ajaxifier les listes (delete, online, offline)
 */
function initListForm() {
	// console.log('initListForm');

	// Set buttons
	var listForm = $('.list-form'),
		contentLocale = listForm.attr('lang'),
		switches = $('.list-form').find('.switch').css('cursor', 'pointer'),
		btnToolbar = $('<div>', {
			class: 'btn-toolbar'
		}).prependTo(listForm),
		buttonGroup = $('<div>', {
			class: 'btn-group'
		}).appendTo(btnToolbar);

	if ($('.list-form .switch').length) {
		buttonGroup.append('<button class="btn btn-default btn-xs" id="btnOnline">En ligne</button>');
		buttonGroup.append('<button class="btn btn-default btn-xs" id="btnOffline">Hors ligne</button>');
	};
	btnToolbar.append('<button class="btn btn-danger btn-xs" id="btnDelete">Supprimer</button>');

	var btnDelete = $('#btnDelete'),
		btnOnline = $('#btnOnline'),
		btnOffline = $('#btnOffline'),
		nbElementItem = $('#nb_elements');

	// Enable delete button
	btnDelete.click(function(){

		var checkedCheckboxes = listForm.find(':checkbox:checked'),
			nombreElementsTraites = 0,
			nombreElementsSelectionnes = checkedCheckboxes.length;

		// Build confirm string
		confirmString = translate('Delete') + ' ' + nombreElementsSelectionnes.toString() + ' ' + translate('item');
		if (nombreElementsSelectionnes > 1) confirmString += 's';
		confirmString += '?';

		if (confirm(confirmString)) {
			checkedCheckboxes.each(function(){
				var id = $(this).val();
				$.ajax({
					type: 'DELETE',
					url: document.URL.split('?')[0] + '/' + id
				}).done(function(){
					$('#item_' + id).slideUp('fast', function () {
						var nbElements = nbElementItem.html();
						nbElementItem.html(nbElements-1);
						$(this).remove();
						nombreElementsTraites++;
						if (nombreElementsSelectionnes == nombreElementsTraites) {
							alertify.success(nombreElementsSelectionnes + ' items deleted.');
						}
					});
				}).fail(function(){
					alertify.error(translate('An error occurred'));
				});
			});
		}

	});

	// Enable online button
	switches.click(function(){
		var item = $(this).closest('li'),
			status = item.hasClass('online') ? 'online' : 'offline' ,
			newStatus = item.hasClass('online') ? 'offline' : 'online' ,
			newStatusValue = item.hasClass('online') ? 0 : 1 ,
			id = $(this).parent().children(':checkbox').val(),
			data = {};
		data['id'] = id;
		data[contentLocale] = {'status' : newStatusValue};
		$('#item_' + id).removeClass(status).addClass(newStatus);
		$.ajax({
			type: 'PATCH',
			url: document.URL.split('?')[0] + '/' + id,
			data: data
		}).done(function(){
			alertify.success('Item set ' + newStatus + '.');
		}).fail(function(){
			alertify.error('Item couldn’t be set ' + newStatus + '.');
		});
	});


	// Enable online button
	btnOnline.click(function(){
		var checkedCheckboxes = listForm.find(':checkbox:checked'),
			nombreElementsTraites = 0,
			nombreElementsSelectionnes = checkedCheckboxes.length;

		checkedCheckboxes.each(function(){
			var id = $(this).val(),
				data = {};
			data['id'] = id;
			data[contentLocale] = {'status' : 1};
			$.ajax({
				type: 'PATCH',
				url: document.URL.split('?')[0] + '/' + id,
				data: data
			}).done(function(){
				$('#item_' + id).removeClass('offline').addClass('online').find(':checkbox').prop({'checked':false});
				nombreElementsTraites++;
				if (nombreElementsSelectionnes == nombreElementsTraites) {
					alertify.success(nombreElementsSelectionnes + ' items set online.');
				}
			}).fail(function(){
				alertify.error('Item couldn’t be set online.');
			});
		});
	});

	// Enable offline button
	btnOffline.click(function(){
		var checkedCheckboxes = listForm.find(':checkbox:checked'),
			nombreElementsTraites = 0,
			nombreElementsSelectionnes = checkedCheckboxes.length;

		checkedCheckboxes.each(function(){
			var id = $(this).val(),
				data = {};
			data['id'] = id;
			data[contentLocale] = {'status' : 0};
			$.ajax({
				type: 'PATCH',
				url: document.URL.split('?')[0] + '/' + id,
				data: data
			}).done(function(){
				$('#item_' + id).removeClass('online').addClass('offline').find(':checkbox').prop({'checked':false});
				nombreElementsTraites++;
				if (nombreElementsSelectionnes == nombreElementsTraites) {
					alertify.success(nombreElementsSelectionnes + ' items set offline.');
				}
			}).fail(function(){
				alertify.error('Item couldn’t be set offline.');
			});
		});
	});

}

!function( $ ){

	"use strict";

	$(function () {

		enableSortable();
		initListForm();

		$('.list-form').listEnhancer({
			done: function(data) {
				reloadPage();
			},
			error: function() {
				reloadPage();
			}
		});

	});

}( window.jQuery || window.ender );
