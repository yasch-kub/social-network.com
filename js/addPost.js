$(document).ready(function(){
    $('#postForm').submit(function(event){
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function(response){
            console.log(response);
            $('#posts').prepend(response);
        });
    });
});