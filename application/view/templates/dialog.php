<div class="panel-body">
    <ul class="chat">
        <?php foreach ($messages as $message): ?>
            <?php if($message['senderId'] == intval(UserModel::getUserId())): ?>
                <? include view . 'templates/message/messageRight.php'; ?>
            <?php else: ?>
                <? include view . 'templates/message/messageLeft.php'; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <div class="row">
        <form method='post' role="form" id="chatForm" action="/addMessage/<? echo $chatId; ?>"
              timestamp="<? echo $timestamp?>"
              connect="/updateMessages/<? echo $chatId; ?>">
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Message...">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success form-control">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>