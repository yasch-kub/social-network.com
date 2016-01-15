<div class="row">
    <div class="col-sm-10 posts-block">
        <p class="user-posts"><? echo $post['message'] ?></p>
        <p class="text-muted">
            <? echo $post['date'] ?> •
            <a href="/<? echo $post['id'] ?>" class="text-muted"><? echo $post['name'] . ' ' . $post['surname'] ?></a>
        </p>
        <p class="comment-like-block">
            <a class="comment" href="#">
                <i class="fa fa-comment"></i>
            </a>
            <a class="like" href="#">
                <i class="fa fa-heart-o"></i>
            </a>
        </p>
    </div>
    <div class="col-sm-2">
        <a href="/<? echo $post['id'] ?>" class="pull-right">
            <img src="<? echo '/application/data/users/' . $post['id'] . '/' .$post['avatar'][0]; ?>" class="img-circle">
        </a>
    </div>
</div>
<!--post answer-->
<div class="row comment">
    <div class="col-sm-2">
        <a href="/<? echo $post['id'] ?>" class="pull-left">
            <img src="<? echo '/application/data/users/' . $post['id'] . '/' .$post['avatar'][0]; ?>" class="img-circle img-comment">
        </a>
    </div>
    <div class="col-sm-10">
        <p class="user-posts post-comment"><? echo $post['message'] ?></p>
    </div>
    <div class="col-md-12">
        <p class="text-muted">
            <? echo $post['date'] ?> •
            <a href="/<? echo $post['id'] ?>" class="text-muted"><? echo $post['name'] . ' ' . $post['surname'] ?></a>
        </p>
    </div>
</div>


<div class="row divider">
    <div class="col-sm-12"><hr></div>
</div>