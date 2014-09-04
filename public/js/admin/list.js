function cleanUrl () {
    return document.URL.split('?')[0];
}

function translate(string) {
    return string;
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
        handle = 'img,div';
        items = '.thumbnail';
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
            var serializedDatas = sortableList.sortable('serialize').replace(/null/g, '0'),
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
        btnDelete = $('#btnDelete'),
        btnOnOff = $('#btnOnline, #btnOffline'),
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

    var statuses = [
        { 'class': 'fa-toggle-off', 'label': 'offline' },
        { 'class': 'fa-toggle-on', 'label': 'online' },
    ];

    /**
     * Enable online / offline switches
     */
    switches.click(function(){
        var id = $(this).closest('li,tr').attr('id').split('_')[1],
            oldStatus = $(this).hasClass(statuses[0].class) ? 0 : 1 ,
            newStatus = Math.abs(oldStatus - 1),
            data = {};
        data['id'] = id;
        if (contentLocale) {
            data[contentLocale] = {'status' : newStatus};
        } else {
            data['status'] = newStatus;
        }
        $(this).removeClass(statuses[oldStatus].class).addClass(statuses[newStatus].class);
        $.ajax({
            type: 'PATCH',
            url: document.URL.split('?')[0] + '/' + id,
            data: data
        }).done(function(){
            alertify.success('Item set ' + statuses[newStatus].label + '.');
        }).fail(function(){
            alertify.error('Item couldn’t be set ' + statuses[newStatus].label + '.');
        });
    });


    /**
     * Enable online / offline submit buttons
     */
    btnOnOff.click(function(){
        console.log(this.id);
        var newStatus = 0;
        if (this.id == 'btnOnline') {
            newStatus = 1;
        }
        var checkedCheckboxes = listForm.find(':checkbox:checked:not(#selectionButton)'),
            nombreElementsTraites = 0,
            nombreElementsSelectionnes = checkedCheckboxes.length,
            url = cleanUrl();

        checkedCheckboxes.each(function(){
            var id = $(this).val(),
                statusSwitch = $('#item_' + id + ' .switch'),
                oldStatus = statusSwitch.hasClass(statuses[0].class) ? 0 : 1,
                checkbox = $(this),
                data = {};
            data['id'] = id;

            if (oldStatus == newStatus) {
                nombreElementsSelectionnes--;
                checkbox.prop({'checked':false});
            }

            if (contentLocale) {
                data[contentLocale] = {'status' : newStatus};
            } else {
                data['status'] = newStatus;
            }

            $.ajax({
                type: 'PATCH',
                url: url + '/' + id,
                data: data
            }).done(function(){
                statusSwitch.removeClass(statuses[oldStatus].class).addClass(statuses[newStatus].class);
                checkbox.prop({'checked':false});
                nombreElementsTraites++;
                if (nombreElementsSelectionnes == nombreElementsTraites) {
                    alertify.success(nombreElementsSelectionnes + ' items set ' + statuses[newStatus].label + '.');
                    $(':checkbox').change();
                }
            }).fail(function(){
                alertify.error('Item couldn’t be set ' + statuses[newStatus].label + '.');
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
            // enter key without ctrl and command
            if (event.keyCode == 13 && ! event.ctrlKey && ! event.metaKey) {
                $(this).blur();
                var number = $(this).index(),
                    nextCell = $(this).parent().next('tr').children('td:eq(' + number + ')');
                if ( ! nextCell.length) {
                    nextCell = $(this).parent().parent().children('tr:first-child').children('td:eq(' + (number + 1) + ')');
                }
                nextCell.focus();
                event.preventDefault();
            }
        });

        $('[contenteditable]').on('focus', function (event) {
            $(this).removeClass('success-fade-out');
            $(this).data('text-original', $(this).text());
        });

        $('[contenteditable]').on('blur', function (event) {
            if ($(this).data('text-original') == $(this).text()) { return }

            var data = {},
                cell = $(this);
            data['id'] = $(this).parent().attr('id').split(/[_]+/).pop();
            data[$(this).attr('data-name')] = $(this).text().trim();

            $.ajax({
                url: cleanUrl() + '/' + data['id'],
                data: data,
                type: 'patch'
            }).done(function(){
                cell.addClass('success-fade-out');
            }).fail(function(){
                cell.addClass('danger');
            });
            // console.log(JSON.stringify(data));
        });


    });

}( window.jQuery || window.ender );
