$(document).ready(function() {
    $('#friendSearchForm').submit(function(event) {
        event.preventDefault();
        var url = $(this).attr('action');
        console.log('Finding...');
        $.post(url, $(this).serialize(), function(response) {
            console.log(response);
            $('#possibleFriendsBox .media-list').html(response);
        })
    })
});