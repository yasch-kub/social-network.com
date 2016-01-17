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

    $('#posts').on('mouseenter mouseleave', '.like', function(event) {
        var i = $(this).find('i')
        if (event.type == 'mouseenter') {
            i.removeClass('fa-heart-o');
            i.addClass('fa-heart');
        } else {
            i.removeClass('fa-heart');
            i.addClass('fa-heart-o');
        }
    });

    $('#posts').on('click', '.like', function() {
        event.preventDefault();
        var url = $(this).attr('href');
        var like = $(this);
        console.log(url);
        $.post(url, '', function(response) {
            window.link = $(this);
            if (response) {
                like.children('span').html(response);
                like.removeClass('like');
                like.addClass('liked');
                var i = like.find('i');
                console.log(i);
                i.removeClass('fa-heart-o');
                i.addClass('fa-heart');
            }
        }, 'json');
    })
});