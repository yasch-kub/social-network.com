<div class="row comment-box">
    <div class="col-sm-2">
        <a href="/<? echo $comment['id'] ?>" class="pull-left">
            <img src="<? echo '/application/data/users/' . $comment['authorId'] . '/' .$comment['avatar'][0]; ?>" class="img-circle img-comment">
        </a>
    </div>
    <div class="col-sm-10">
        <p class="user-posts post-comment"><? echo $comment['message'] ?></p>
    </div>
    <div class="col-md-12">
        <p class="text-muted">
            <? echo $comment['date'] ?> •
            <a href="/<? echo $comment['id'] ?>" class="text-muted"><? echo $comment['name'] . ' ' . $comment['surname'] ?></a>
        </p>
    </div>
</div>