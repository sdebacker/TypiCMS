$(function () {
    /**
     * Dropzone multi-upload
     */
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

    var acceptedFiles = [
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'application/msword', // doc
        'application/vnd.ms-powerpoint', // ppt
        'application/vnd.ms-excel', // xls
        'application/pdf',
        'image/jpeg',
        'image/gif',
        'image/png'
    ];

    Dropzone.options.dropzone = {
        clickable: true,
        maxFilesize: 2, // MB
        acceptedFiles: acceptedFiles.join(),
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
                            alertify.error('An error occurred while sorting files.');
                        });
                    }
                }
            });
        }
    };
});
