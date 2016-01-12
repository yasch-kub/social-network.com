$(document).ready(function(){
    $('#slider .fa-angle-right').click(function(event){
        var images= $('#slidePhoto img');
        var img = images.last();
        var num = img.attr('num');
        var id = img.attr('src').split('/')[4];
        var obj = {
            'num' : parseInt(num),
            'id' : id
        };
        console.log(obj);
        $.post('/getSlide', JSON.stringify(obj), function(data){
            for (var i = 0; i < 4 - data.photos.length ; i++){
                $(images[i]).attr('src', $(images[data.photos.length + i]).attr('src'));
            }

            for (var i = 4 - data.photos.length ; i < 4 ; i++)
                $(images[i]).attr('src', '/application/data/users/'+ id +'/photos/' + data.photos.shift());

        }, 'json');

    });


});