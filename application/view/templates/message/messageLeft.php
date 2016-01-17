<li class="left clearfix">
    <span class="chat-img pull-left">
        <img src="<? echo '/application/data/users/' . $message['senderId'] . '/' . $message['avatar'][0]; ?>" class="img-circle" />
    </span>
    <div class="chat-body clearfix">
        <div class="header">
            <strong class="primary-font">
                <? echo $message['senderName']; ?>
            </strong>
            <small class="pull-right text-muted">
                <span class="glyphicon glyphicon-time"></span>
                <? echo $message['date']; ?>
            </small>
        </div>
        <p>
            <? echo $message['text']; ?>
        </p>
    </div>
</li>