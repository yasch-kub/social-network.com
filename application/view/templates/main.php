<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            Information
        </div>
    </div>
</div>

<div class="row info-block">
    <div class="profile-property col-md-3">
        Name:
    </div>
    <div class="col-md-9">
        Marcus
    </div>
    <div class="profile-property col-md-3">
        LastName:
    </div>
    <div class="col-md-9">
        Due
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
                                                  placeholder="Left your post"></textarea>
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