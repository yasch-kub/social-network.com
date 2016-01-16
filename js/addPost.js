$(document).ready(function(){
    $('#postForm').submit(function(event){
        event.preventDefault();

        var form = $(this)
        $.post($(this).attr('action'), $(this).serialize(), function(response){
            console.log(response);
            $('#posts').prepend(response);
            form.trigger('reset');
        });
    });

    $('#posts').on('submit', '#postCommentForm', function(event){
        event.preventDefault();

        var form = $(this)
        $.post($(this).attr('action'), $(this).serialize(), function(response){
            console.log(response);
            form.parents('#commentsBox').prepend(response);
            form.trigger('reset');
        });
    });
});