$(document).ready(function(){
    $('#slider .fa-angle-right').click(function(event){
        var button = $(this);
        var images= $('#slidePhoto img');
        var img = images.last();
        var num = img.attr('num');
        var id = img.attr('src').split('/')[4];
        var obj = {
            'num' : parseInt(num),
            'id' : id,
            'direction' : 'right'
        };
        console.log(obj);
        $.post('/getSlide', JSON.stringify(obj), function(data){
            console.log(data);
            var nNewPhotos = data.photos.length;
            if (nNewPhotos != 0) {
                button.css('opacity', '1');

                while (data.photos.length != 0) {
                    var clone = $('#containerPhoto div').last().clone();
                    clone.find('img').attr({
                        'src': '/application/data/users/'+ id +'/photos/' + data.photos.shift(),
                        'num' : parseInt(++num)
                    });
                    $('#containerPhoto').append(clone);
                }
                $("#containerPhoto").animate({
                    marginLeft: '-=' + nNewPhotos * 25 + '%'
                }, 500, function() {
                    $('#containerPhoto div').slice(0, nNewPhotos).remove();
                    $("#containerPhoto").css({
                        marginLeft: '0px'
                    });
                });
            }
            else
                button.css('opacity', '0.3');
        }, 'json');


    });

    $('#slider .fa-angle-left').click(function(event){
        var button = $(this);
        var images= $('#slidePhoto img');
        var img = images.first();
        var num = img.attr('num');
        var id = img.attr('src').split('/')[4];
        var obj = {
            'num' : parseInt(num),
            'id' : id,
            'direction' : 'left'
        };

        $.post('/getSlide', JSON.stringify(obj), function(data){
            console.log(data);
            var nNewPhotos = data.photos.length;
            if (nNewPhotos != 0) {
                button.css('opacity', '1');
                while (data.photos.length != 0) {
                    var clone = $('#containerPhoto div').last().clone();
                    clone.find('img').attr({
                        'src': '/application/data/users/'+ id +'/photos/' + data.photos.pop(),
                        'num' : parseInt(--num)
                    });
                    $('#containerPhoto').prepend(clone);
                    $("#containerPhoto").css({
                        marginLeft: '-=' + nNewPhotos * 25 + '%'
                    });
                }
                $("#containerPhoto").animate({
                    marginLeft: '0'
                }, 500, function() {
                    $('#containerPhoto div').slice($(this).length - nNewPhotos, nNewPhotos).remove();
                });
            }
            else
                button.css('opacity', '0.3');
        }, 'json');
    });


});