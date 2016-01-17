$(document).ready(function() {
    var messager = new Messager('ul.chat', '#chatForm');
    window.messager = messager;
});

function Messager(messageBoxSelector, formSelector) {
    this.messageBox = $(messageBoxSelector);
    this.form = $(formSelector);
    this.sendUrl = this.form.attr('action');

    this.checkUrl = this.form.attr('connect');
    this.form.removeAttr('connect');

    this.timestamp = this.form.attr('timestamp');
    this.form.removeAttr('timestamp');

    console.log(this.timestamp);

    // Add listener to send button
    this.form.submit($.proxy(function(event) {
        event.preventDefault();
        this.send();
    }, this));

    console.log(this.sendUrl);
    this.connect();
}

Messager.prototype.send = function() {
    $.post(this.sendUrl, this.form.serialize(), $.proxy(this.success, this), 'json');
    this.form.trigger('reset');
};

Messager.prototype.printMessage = function(message) {
    this.messageBox.append(message);
};

Messager.prototype.success = function(response) {
    if (response.status == 'OK')
        console.log('Message saved');
};

Messager.prototype.update = function(response) {
    if (response.template != 'undefined')
        this.printMessage(response.template);
    this.timestamp = response.timestamp;

    console.log(response);
};

Messager.prototype.connect = function() {
    setInterval($.proxy(function() {
        $.post(this.checkUrl, JSON.stringify(this.timestamp), $.proxy(this.update, this), 'json');
    }, this), 3000);
};
