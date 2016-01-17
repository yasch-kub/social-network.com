$(document).ready(function(){
    var prevValue;

    $('.add-info-plus').click(function(){
        if ($('.add-information').css('display') == 'none')
            $('.add-information').show();
        else
            $('.add-information').hide();
    });

    $('.information-plus').click(function(){

        var obj = {
            'info' : $('input[name="info"]').val().trim(),
            'value' : $('input[name="value"]').val().trim()
        };

        if (obj.info.length != 0 && obj.value.length != 0) {
            $.post('addinfo', JSON.stringify(obj), function (response) {
                console.log(response);
                var html = '<div class="info profile-property col-md-3">' + obj.info + '</div><div class="val col-md-9">' + obj.value + '<i class="pull-right dell-info fa fa-minus-square-o"></i></div>';
                $('.add-information').before(html);
                $('input[name="info"]').val('');
                $('input[name="value"]').val('');
            });
            $('.add-information').hide();
        }
        else
            return false;
    });

    //delete information
    $('.info-block').on('mouseenter mouseleave', '.val', function(e){
        if (e.type == 'mouseenter')
            $(this).find('i').show();
        else
            $(this).find('i').hide();
         });

    $('.info-block').on('click','.dell-info',function(){
        var data = {
            'info' : $(this).parent('div').prev().text().trim(),
            'val' : $(this).parent('div').text().trim()
        };
        $(this).parent('div').prev().remove();
        $(this).parent('div').remove();
        $.post('dellinfo', JSON.stringify(data), function(response){
            console.log(response);
        });
    });

    //change information
    $('.info-block').on('dblclick', '.val', function(){
        var valDiv = $(this);
        prevValue = $(this).text().trim();
        valDiv.replaceWith('<div class="col-md-9"><input type="text" class="infoInput form-control" value="' + $(this).text().trim() + '"></div>');
        $('.infoInput').focus();
    });

    $('.info-block').on('focusout', '.infoInput', function(){
        var data = {
            'info' : $(this).parent().prev().text().trim(),
            'val' : $(this).val().trim(),
            'prevValue' : prevValue
        };

        $.post('changeInfo', JSON.stringify(data), function(response){
            console.log(response);
        });

        $(this).parent().replaceWith('<div class="val col-md-9">' + data.val +
            '<i class="pull-right dell-info fa fa-minus-square-o"></i></div>');

    })
});