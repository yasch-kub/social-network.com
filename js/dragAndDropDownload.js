$(document).ready(function() {

    function fileUploader(dropzone, url, onover, onleave, success) {
        this.allowedFileTypes = ["image/png", "image/jpeg", "image/gif"];
        this.data = new FormData();
        this.dropzone = document.getElementById(dropzone);
        this.url = url;
        this.onleave = onleave;
        this.onover = onover;
        this.success = success;

        this.setUpListeners();
    }

    fileUploader.prototype.setUpListeners = function() {
        this.dropzone.ondrop = $.proxy(function(event) {
            event.preventDefault();
            if (event.dataTransfer.files.length != 0)
                this.upload(event.dataTransfer.files);
            this.onleave();
        }, this);

        this.dropzone.ondragover = this.onover;

        this.dropzone.ondragleave = this.onleave;
    }
;
    fileUploader.prototype.upload = function(files) {
        var isPhotoToSend = false;
        for(var i = 0; i < files.length; i++)
            if ($.inArray(files[i].type, this.allowedFileTypes) != -1) {
                this.data.append('files[]', files[i]);
                isPhotoToSend = true
            }
            else
                console.log('File "' + files[i].name + '" has wrong type! Supported types: ' + allowedFileTypes.toString());

        if (isPhotoToSend)
            this.request();
    };

    fileUploader.prototype.request = function() {
        this.xhr = new XMLHttpRequest();
        var success = this.success;

        this.xhr.onload = function() {
            success(this.responseText);
        };

        this.xhr.upload.onprogress = function(event){
            if (event.lengthComputable) {
                var percentComplete = event.loaded * 100 / event.total;
                console.log(percentComplete + '%');
            }
        };

        this.xhr.upload.onerror = function(){
            console.log('Error occured!');
        };

        this.xhr.upload.onload = function(){
            console.log('File is uploaded!');
        };

        this.xhr.open('POST', this.url);
        this.xhr.send(this.data);
        this.data = new FormData();
    };

    var avatarUploader = new fileUploader('avatarDropzone', '/changeAvatar', avatarDragOver, avatarDragLeave, avatarUploadSuccess);
    var photosUploader = new fileUploader('galleryDropZone', '/addPhotos', galleryDragEvent, galleryDragEvent, photosUploadSuccess);
});

function avatarDragOver() {
    $('.dropzone').show();
    return false;
}

function avatarDragLeave() {
    $('.dropzone').hide();
    return false;
}

function avatarUploadSuccess(response) {
    var images = JSON.parse(response);
    console.log(images);
    $('#avatarDropzone img').attr('src', images.pop());
}

function photosUploadSuccess(response) {
    var images = JSON.parse(response);
    console.log(images);
    images.forEach(function(image) {
        console.log(image);
        var div = '<div class="col-md-3 col-lg-4 col-sm-4 col-xs-12 thumb"><a><img class="img-responsive" src="' + image + '"></a></div>';
        $('#galleryPhotos').append(div);
    });
    console.log(images);
}

function galleryDragEvent() {
    $('#galleryDropZone').toggleClass('dragenter');
    return false;
}