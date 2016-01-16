$(document).ready(function(){
    $('#follow').click(function(){
        var id = $(this).attr('value');
        $(this).hide();
        $.post('follow', id, function(response){
            console.log(response);
            $('body').append(response);
        })
    });
});