!function( $ ){

    "use strict";

    $(function () {

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
                url: document.URL.split('?')[0] + '/' + data['id'],
                data: data,
                type: 'PUT'
            }).done(function(){
                cell.addClass('success-fade-out');
            }).fail(function(){
                cell.addClass('danger');
            });
        });


    });

}( window.jQuery || window.ender );
