<div class="panel-body">
    <ul class="chat">
        <?php foreach ($messages as $message): ?>
            <?php if($message['senderId'] == intval(UserModel::getUserId())): ?>
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
            <?php else: ?>
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
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <div class="row">
        <form method='post' role="form" id="chatForm" action="/addMessage/<? echo $chatId; ?>">
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Message...">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success form-control">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>