<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            Friends
        </div>
    </div>
</div>

<div class="row">
    <div class="panel-body">
        <ul class="media-list">
            <? foreach ($followers as $follower):?>
            <li class="media">
                <div class="media-body">
                    <div class="media">
                        <a class="pull-left" href="<? echo '/' . $follower['_id']; ?>">
                            <img class="media-object img-circle friends-image"
                                 src="<? echo '/application/data/users/' . $follower['_id'] . '/' . $follower['avatar'][0]; ?>">
                        </a>
                        <div class="media-body">
                            <h5><? echo $follower['name'] . ' ' . $follower['surname'] ?></h5>
                            <!--<small class="text-muted">Active From 3 hours</small>-->
                        </div>
                    </div>
                </div>
            </li>
            <? endforeach; ?>
        </ul>
    </div>
</div>