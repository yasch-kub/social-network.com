$(document).ready(function(){
    $('.btn-success').click(function(){
        var obj = {};

        if ($('#bg').val().trim().length != 0)
            obj.backgroundcolor = $('#bg').val().trim();
        if ($('#mcolor').val().trim().length != 0)
            obj.usermenucolor = $('#mcolor').val().trim();
        if ($('#mhover').val().trim().length != 0)
            obj.usermenuhover = $('#mhover').val().trim();
        if ($('#mactive').val().trim().length != 0)
            obj.usermenuactive = $('#mactive').val().trim();
        console.log(obj);
        $.post('/changeUserStyle', JSON.stringify(obj), function(response){
           console.log(response);
            location.reload();
        });
    });

    $('.fa-reply-all').click(function(){
        $.post('/revertStyle',null, function(response){
            console.log(response);
            location.reload();
        });
    });
});