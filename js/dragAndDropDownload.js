window.onload = function(){
    var dropzone = document.getElementById('avatarDropzone');

    dropzone.ondrop = function(event) {
        event.preventDefault();
        if (event.dataTransfer.files.length != 0)
            upload(event.dataTransfer.files);
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
    var data = new FormData();

    console.log(files);
    for(var i = 0; i < files.length; i++)
        data.append('files[]', files[i]);

    $.ajax({
        url: '/changeAvatar',
        type: 'post',
        data: data,
        processData: false,
        contentType: false,
        success: function(data) {
            $('#avatarDropzone img').attr('src', data);
            $('body').append(data);
            console.log(data);
        }
    });
}