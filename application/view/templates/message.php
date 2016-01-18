<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            <? echo $dictionary['messages'] ?>
        </div>
    </div>
</div>
<?php foreach ($user['chats'] as $chat):?>
    <div class="row page-header message">
        <div class="col-lg-1 col-md-1">
            <a class="pull-left" href="/dialog/<? echo $chat['id']; ?>">
                <img class="media-object img-circle friends-image" src="<? echo '/application/data/users/' . $chat['memberId'] . '/' . $chat['avatar']; ?>">
            </a>
        </div>
        <div class="col-lg-9 col-md-9">
            <a href="/dialog/<? echo $chat['id']; ?>">
                <? echo $chat['memberName'] ?>
            </a>
            <div class="message-text">
                <a href="/dialog/<? echo $chat['id']; ?>">
                    <? echo $chat['lastMessage']; ?>
                </a>
            </div>
        </div>
    </div>
<? endforeach; ?>