<div class="row">
    <div class="col-sm-10 posts-block">
        <p class="user-posts"><? echo $post['message'] ?></p>
        <p class="text-muted">
            <? echo $post['date'] ?> •
            <a href="/<? echo $post['authorId']; ?>" class="text-muted"><? echo $post['name'] . ' ' . $post['surname'] ?></a>
        </p>
        <p class="comment-like-block">
            <a class="<? echo $post['isLiked'] ? 'liked' : 'like'; ?>" href="/addPostLike/<? echo $id . '/' . $post['id']; ?>">
                <span>
                    <? echo $post['likeNumber']; ?>
                </span>
                <i class="fa <? echo $post['isLiked'] ? 'fa-heart' : 'fa-heart-o'; ?>"></i>
            </a>
        </p>
    </div>
    <div class="col-sm-2">
        <a href="/<? echo $post['authorId'] ?>" class="pull-right">
            <img src="<? echo '/application/data/users/' . $post['authorId'] . '/' .$post['avatar'][0]; ?>" class="img-circle">
        </a>
    </div>
</div>

<div id="commentsBox">
    <?php foreach ($post['comments'] as $comment): ?>
        <?php include view . 'templates/comment.php'; ?>
    <? endforeach; ?>
    <div class="row comment-box">
        <form role="form" id="postCommentForm" action="/addComment/<? echo $id . '/' . $post['id']; ?>">
            <div class="input-group">
                <input type="text" name="comment" class="form-control" aria-label="..."
                       placeholder="<? echo $dictionary['comment'] ?>">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success form-control"><? echo $dictionary['send'] ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row divider">
    <div class="col-sm-12"><hr></div>
</div>