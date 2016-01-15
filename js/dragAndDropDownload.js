window.onload = function(){
    var dropzone = document.getElementById('avatarDropzone');

    dropzone.ondrop = function(event) {
        $('.dropzone').hide();
        event.preventDefault();
        if (event.dataTransfer.files.length != 0)
            upload(event.dataTransfer.files);
        $('.dropzone').hide();
    };

    dropzone.ondragover = function() {
        $('.dropzone').show();
        return false;
    };

    dropzone.ondragleave = function() {
        $('.dropzone').hide();
        return false;
    }
};

function upload(files) {
    var allowedFileTypes = ["image/png", "image/jpeg", "image/gif"];
    var fileAppend;

    console.log(files);
    for(var i = 0; i < files.length; i++)
        if ($.inArray(files[i].type, allowedFileTypes) != -1) {
            var data = new FormData();
            data.append('files[]', files[i]);
            $.ajax({
                url: '/changeAvatar',
                type: 'post',
                data: data,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#avatarDropzone img').attr('src', data);
                    console.log(data);
                },
                xhr: function()
                {
                    var xhr = new XMLHttpRequest();

                    //Upload progress
                    xhr.upload.onprogress = function(event){
                        if (event.lengthComputable) {
                            var percentComplete = event.loaded * 100 / event.total;
                            $('.progress-bar-success').width(percentComplete + '%');
                            console.log(percentComplete + '%');
                        }
                    };

                    xhr.upload.onerror = function(){
                        console.log('Error occured!');
                    };

                    xhr.upload.onload = function(){
                        console.log('File is uploaded!');
                    };

                    return xhr;
                }
            });
        }
        else
            console.log('File "' + files[i].name + '" has wrong type! Supported types: ' + allowedFileTypes.toString())
}