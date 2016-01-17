<li class="media">
    <div class="media-body">
        <div class="media">
            <a class="pull-left" href="<? echo '/' . $follower['_id']; ?>">
                <img class="media-object img-circle friends-image"
                     src="<? echo '/application/data/users/' . $follower['_id'] . '/' . $follower['avatar'][0]; ?>">
            </a>
            <a href="<? echo '/' . $follower['_id']; ?>">
                <div class="media-body">
                    <h5><? echo $follower['name'] . ' ' . $follower['surname'] ?></h5>
                    <!--<small class="text-muted">Active From 3 hours</small>-->
                </div>
            </a>
        </div>
    </div>
</li>