$(document).ready(function(){
    var curImageParent;

    $(".img-responsive").click(function(){
        curImageParent = $(this).parents('.thumb');
        $('.carousel-inner').html($(this).clone());
        $("#modal-gallery").modal("show");
    });

    $('.left').click(function(){
        if(curImageParent.prev().length != 0) {
            curImageParent = curImageParent.prev();
            changePhoto(curImageParent);
        }
    });
    $('.right').click(function () {
        if(curImageParent.next().length != 0) {
            curImageParent = curImageParent.next();
            changePhoto(curImageParent);
        }
    });
    
});

function changePhoto(curImageParent){
    $('.carousel-inner').fadeOut(100, function(){
        $(this).html(curImageParent.find('img').clone());
        $(this).fadeIn(100);
    });
}