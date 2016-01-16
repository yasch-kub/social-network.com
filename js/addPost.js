$(document).ready(function(){
    $('#postForm').submit(function(event){
        event.preventDefault();

        var form = $(this);
        if($(this).children('textarea').val().trim().length != 0)
            $.post($(this).attr('action'), $(this).serialize(), function(response){
                console.log(response);
                $('#posts').prepend(response);
                form.trigger('reset');
            });
    });

    $('#posts').on('submit', '#postCommentForm', function(event){
        event.preventDefault();

        var form = $(this);
        if($(this).find('input').val().trim().length != 0)
            $.post($(this).attr('action'), $(this).serialize(), function(response){
                console.log(response);
                form.parents('.comment-box').before(response);
                form.trigger('reset');
            });
    });
});