window.onload = function(){
    var dropzone = document.getElementById('avatarDropzone');

    dropzone.ondrop = function(event) {
        event.preventDefault();
        //this.className = 'dragover';
        upload(event.dataTransfer.files);
    };

    dropzone.ondragover = function() {
        //this.className = 'dragover';
        return false;
    };

    dropzone.ondragleave = function() {
        //this.className = '';
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
            //$('body').append(data);
            console.log(data);
        }
    });
}