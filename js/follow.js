$(document).ready(function(){
    $('#follow').click(function(event){
        event.preventDefault();
        var id = $(this).attr('value');
        $(this).remove();
        $.post('follow', id, function(response){
            console.log(response);
            $('body').append(response);
        })
    });
});