$(document).ready(function(){
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
                var html = '<div class="profile-property col-md-3">' + obj.info + '</div><div class="col-md-9">' + obj.value + '</div>';
                $('.add-information').before(html);
                $('input[name="info"]').val('');
                $('input[name="value"]').val('');
            });
            $('.add-information').hide();
        }
        else
            return false;
    })
});