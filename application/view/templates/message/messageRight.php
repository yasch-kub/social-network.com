<li class="right clearfix">
    <span class="chat-img pull-right">
        <img src="<? echo '/application/data/users/' . $message['senderId'] . '/' . $message['avatar'][0]; ?>" class="img-circle" />
    </span>
    <div class="chat-body clearfix">
        <div class="header">
            <small class=" text-muted">
                <span class="glyphicon glyphicon-time"></span>
                <? echo $message['date']; ?>
            </small>
            <strong class="pull-right primary-font">
                <? echo $message['senderName']; ?>
            </strong>
        </div>
        <p>
            <? echo $message['text']; ?>
        </p>
    </div>
</li>