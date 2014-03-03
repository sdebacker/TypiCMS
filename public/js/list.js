function cleanUrl () {
	return document.URL.split('?')[0];
}

function enableSortable() {
	// Sorting avec imbrication
	var sortableList = $('.sortable'),
		maxLevels = 1,
		isTree = false,
		handle = 'div',
		placeholder = 'placeholder',
		toleranceElement = '> div',
		items = 'li',
		url = document.URL.split('?')[0] + '/sort';

	if (sortableList.hasClass('nested')) {
		maxLevels = 3;
		isTree = true;
		sortableList.find('li > div').prepend('<span class="disclose"></span>');
	}

	if (sortableList.hasClass('sortable-thumbnails')) {
		handle = 'img';
		items = 'a';
		placeholder = false;
		toleranceElement = false;
		url = '/admin/files/sort';
	}
	
	var sortableOptions = {
		forcePlaceholderSize: true,
		handle: handle,
		cancel: 'input, .label, .attachments a, .mjs-nestedSortable-branch .disclose',
		helper: 'clone',
		// distance: 2,
		items: items,
		opacity: .6,
		placeholder: placeholder,
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: toleranceElement,
		maxLevels: maxLevels,
		listType: 'ul',
		isTree: isTree,
		expandOnHover: 700,
		startCollapsed: false,
		update: function(event, ui) {
			var serializedDatas = sortableList.sortable('serialize'),
				elementId = ui.item.attr('id').split(/[_]+/).pop();
			if (isTree) {
				serializedDatas += '&nested=true&moved=' + elementId;
			}
			$.ajax({
				type: 'POST',
				url: url,
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
		switches = $('.switch').css('cursor', 'pointer'),
		btnToolbar = listForm.children('.btn-toolbar'),
		buttonGroup = $('<div>', {
			class: 'btn-group'
		});
		buttonGroup.prependTo(btnToolbar);
		btnToolbar.append('<div class="btn-group"><button class="btn btn-danger btn-xs" id="btnDelete">Supprimer</button></div>');

	if ($('.list-form .switch').length) {
		buttonGroup.append('<button class="btn btn-default btn-xs" id="btnOnline">En ligne</button>');
		buttonGroup.append('<button class="btn btn-default btn-xs" id="btnOffline">Hors ligne</button>');
	};

	var btnDelete = $('#btnDelete'),
		btnOnline = $('#btnOnline'),
		btnOffline = $('#btnOffline'),
		nbElementItem = $('#nb_elements');

	// Enable delete checkboxes
	btnDelete.click(function(){

		var checkedCheckboxes = listForm.find(':checkbox:checked:not(#selectionButton)'),
			nombreElementsTraites = 0,
			nombreElementsSelectionnes = checkedCheckboxes.length;

		// Build confirm string
		confirmString = translate('Delete') + ' ' + nombreElementsSelectionnes.toString() + ' ' + translate('item');
		if (nombreElementsSelectionnes > 1) confirmString += 's';
		confirmString += '?';

		if (confirm(confirmString)) {
			var url = cleanUrl();
			checkedCheckboxes.each(function(){
				var id = $(this).val();
				$.ajax({
					type: 'DELETE',
					url: url + '/' + id
				}).done(function(){
					$('#item_' + id).slideUp('fast', function () {
						var nbElements = nbElementItem.html();
						nbElementItem.html(nbElements-1);
						$(this).remove();
						nombreElementsTraites++;
						if (nombreElementsSelectionnes == nombreElementsTraites) {
							alertify.success(nombreElementsSelectionnes + ' items deleted.');
							$(':checkbox').change();
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
		var item = $(this).closest('li,tr'),
			status = item.hasClass('online') ? 'online' : 'offline' ,
			newStatus = item.hasClass('online') ? 'offline' : 'online' ,
			newStatusValue = item.hasClass('online') ? 0 : 1 ,
			id = item.attr('id').split('_')[1],
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


	// Enable online checkboxes
	btnOnline.click(function(){
		var checkedCheckboxes = listForm.find(':checkbox:checked:not(#selectionButton)'),
			nombreElementsTraites = 0,
			nombreElementsSelectionnes = checkedCheckboxes.length,
			url = cleanUrl();


		checkedCheckboxes.each(function(){
			var id = $(this).val(),
				data = {};
			data['id'] = id;
			data[contentLocale] = {'status' : 1};
			$.ajax({
				type: 'PATCH',
				url: url + '/' + id,
				data: data
			}).done(function(){
				$('#item_' + id).removeClass('offline').addClass('online').find(':checkbox').prop({'checked':false});
				nombreElementsTraites++;
				if (nombreElementsSelectionnes == nombreElementsTraites) {
					alertify.success(nombreElementsSelectionnes + ' items set online.');
					$(':checkbox').change();
				}
			}).fail(function(){
				alertify.error('Item couldn’t be set online.');
			});
		});
	});

	// Enable offline checkboxes
	btnOffline.click(function(){
		var checkedCheckboxes = listForm.find(':checkbox:checked:not(#selectionButton)'),
			nombreElementsTraites = 0,
			nombreElementsSelectionnes = checkedCheckboxes.length,
			url = cleanUrl();

		checkedCheckboxes.each(function(){
			var id = $(this).val(),
				data = {};
			data['id'] = id;
			data[contentLocale] = {'status' : 0};
			$.ajax({
				type: 'PATCH',
				url: url + '/' + id,
				data: data
			}).done(function(){
				$('#item_' + id).removeClass('online').addClass('offline').find(':checkbox').prop({'checked':false});
				nombreElementsTraites++;
				if (nombreElementsSelectionnes == nombreElementsTraites) {
					alertify.success(nombreElementsSelectionnes + ' items set offline.');
					$(':checkbox').change();
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
		$('.list-main.nested').nestedCookie();
		initListForm();

		$('.list-form').listEnhancer({
			done: function(data) {
				reloadPage();
			},
			error: function() {
				reloadPage();
			}
		});

		// Save translations
		$('[contenteditable]').on('keyup', function (event) {
			if (event.keyCode == 27) { // esc key pressed
				// Restore state
				document.execCommand('undo');
				$(this).blur();
			}
		});

		$('[contenteditable]').on('keypress', function (event) {
			if (event.keyCode == 13 && ! event.ctrlKey && ! event.metaKey) {
				$(this).blur();
				var number = $(this).index();
				$(this).parent().next('tr').children('td:eq(' + number + ')').focus();
				event.preventDefault();
			}
		});

		$('[contenteditable]').on('blur', function (event) {
			var data = {};

			data['id'] = $(this).parent().attr('id').split(/[_]+/).pop();;
			data[$(this).attr('data-name')] = $(this).html();

			$.ajax({
				url: cleanUrl() + '/' + data['id'],
				data: data,
				type: 'patch'
			});			
			// console.log(JSON.stringify(data));
		});


	});

}( window.jQuery || window.ender );
