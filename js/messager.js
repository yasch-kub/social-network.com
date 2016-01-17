$(document).ready(function() {
    var messager = new Messager()
});

function Messager() {
    var form = $('#chatForm input[type=text]');
    this.checkUrl = '/';
    this.url = form.attr('action');
    this.message = form.val().trim();
    this.messageBox = $('ul.chat');
    this.connect();
}

messager.prototype.send = function() {
    $.post(url, this.message, this.success);
};

messager.prototype.success = function(response) {
    this.messageBox.append(template).addClass('pull-right').find('strong').addClass('pull-right');
}

message.prototype.template = function(name, text, image, date) {
    var template =
        '<li class="right clearfix"><span class="chat-img">' +
        '<img src="' + image + '" alt="User Avatar" class="img-circle" />' +
        '</span>' +
        '<div class="chat-body clearfix">' +
        '<div class="header">' +
        '<small class=" text-muted"><span class="glyphicon glyphicon-time"></span>' + date + '</small>' +
        '<strong class="primary-font">' + name + '</strong>' +
        '</div>' +
        '<p>' +
        text +
        '</p>' +
        '</div>' +
        '</li>';

    return template;
}

messager.prototype.connect = function() {
    setTimeout(function() {
        $.post('/checkChanges', '', this.update, 'json');
    }, 5000);
}

messager.prototype.update = function(response) {
    response.forEach(function(item) {
        var template = this.template(item.name, item.text, item.image, item.date).;
        this.messageBox.append(template).addClass('pull-left');
    });
};

