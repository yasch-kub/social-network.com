<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            <? echo $dictionary['friends'] ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="panel-body">
        <ul class="media-list">
            <? foreach ($followers as $follower):?>
                <?php include view . 'templates/friend.php'; ?>
            <? endforeach; ?>
        </ul>
    </div>
</div>

<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            <? echo $dictionary['possible'] ?>
        </div>
    </div>
</div>

<div class="row">
    <form role="form" id="friendSearchForm" class="center-block" method='post' action="/findFriend">
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="<? echo $dictionary['findfriends'] ?>">
            <div class="input-group-btn">
                <button type="submit" class="btn btn-default form-control"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
</div>

<div class="row" id="possibleFriendsBox">
    <div class="panel-body">
        <ul class="media-list">

        </ul>
    </div>
</div>
