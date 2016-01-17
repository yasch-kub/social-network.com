<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            Information
            <?php if ($id == UserModel::getUserId()):?>
                <i class="fa fa-plus-square-o pull-right add-info-plus"></i>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row info-block">
    <div class="profile-property col-md-3">
        Name:
    </div>
    <div class="col-md-9">
        <? echo $user['name']; ?>
    </div>
    <div class="profile-property col-md-3">
        LastName:
    </div>
    <div class="col-md-9">
        <? echo $user['surname']; ?>
    </div>

    <?php   foreach ($user['information'] as $item): ?>
        <div class="info profile-property col-md-3">
            <? echo key($item); ?>
        </div>
        <div class="val col-md-9">
            <? echo current($item); ?>
            <?php if ($id == UserModel::getUserId()):?>
                <i class="pull-right dell-info fa fa-minus-square-o"></i>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="add-information">
        <div class="col-md-3">
            <input name="info" placeholder="information" class="form-control">
        </div>
        <div class="col-md-3">
            <input name="value" placeholder="value" class="form-control">
        </div>
        <div class="col-md-4">
            <i class="fa fa-plus-square-o information-plus"></i>
        </div>
    </div>
</div>

<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            Photos
        </div>
    </div>
</div>

<div class="row">
    <? include(view . 'templates/slider.php'); ?>
</div>


<div class="column col" id="main">
    <div class="padding">
        <div class="full col">
            <div class="row" id="featured">
                <div class="col-sm-12">
                    <div class="page-header text-muted">
                        Wall
                    </div>
                </div>
            </div>
            <!--comment-->
            <div class="row">
                <div class="col-sm-12">
                    <form id="postForm" class="form-horizontal well" role="form"
                          action="/addPost/<? echo $id; ?>">
                        <textarea name="message" class="form-control"
                                  placeholder="Left your post here..."></textarea>
                        <button class="btn btn-success pull-right" type="submit">Post</button>
                    </form>
                </div>
            </div>
            <div id="posts">
                <?php foreach (array_reverse($posts) as $post)
                    include(view . 'templates/post.php');
                ?>
            </div>
        </div>
    </div>
</div>