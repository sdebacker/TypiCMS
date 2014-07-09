var lang = $('html').attr('lang'),
    langues = ['fr', 'nl', 'en'],
    content = [];

function translate(string) {
    return string;
}

!function( $ ){

    "use strict";

    $(function () {

        var dropZoneTemplate = '<div class="thumbnail dz-preview dz-file-preview">\
                <div class="dz-details">\
                    <div class="thumb-container">\
                        <img data-dz-thumbnail src="" alt="">\
                    </div>\
                    <div class="caption">\
                        <small data-dz-name></small>\
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
            acceptedFiles: 'application/pdf,image/jpeg,image/gif,image/png',
            previewTemplate: dropZoneTemplate,
            previewsContainer: '.dropzone-previews',
            thumbnailWidth: 130,
            thumbnailHeight: 130,
            init: function () {
                var totalFiles = 0,
                    completeFiles = 0;
                this.on("complete", function (file) {
                    completeFiles += 1;
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        // Update positions
                        var files = this.getAcceptedFiles();
                        var done = 0;
                        for (var key in files){
                            var object = jQuery.parseJSON( files[key].xhr.responseText );
                            object.position = parseInt($('#nb_elements').text()) + parseInt(key);
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

        // Offcanvas
        $('[data-toggle="offcanvas"]').click(function () {
            $('.row-offcanvas').toggleClass('active')
        });

    });

}( window.jQuery || window.ender );
