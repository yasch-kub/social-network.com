<div class="container">
    <div class="row profile">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div id="avatarDropzone" class="profile-userpic">
                    <img src="<? echo '/application/data/users/' . $id . '/' .$user['avatar'][0]; ?>" class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <? echo $user['name'] .' '.$user['surname'] ?>
                    </div>
                    <div class="profile-usertitle-job">
                        Developer
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    <button type="button" class="btn btn-success btn-sm">Follow</button>
                    <button type="button" class="btn btn-danger btn-sm">Message</button>
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="active">
                            <a href="#">
                                <i class="glyphicon glyphicon-home"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-users"></i>
                                Friends
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                Messages
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-newspaper-o"></i>
                                News
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="glyphicon glyphicon-cog"></i>
                                Account Settings
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
        </div>

        <div class="col-md-7">
            <div class="profile-content">

                <div class="profile-content">

                    <div class="row" id="featured">
                        <div class="col-sm-12">
                            <div class="page-header text-muted">
                                Information
                            </div>
                        </div>
                    </div>

                    <div class="row info-block">
                        <div class="profile-property col-md-3">Name:</div>
                        <div class="col-md-9">Marcus</div>
                        <div class="profile-property col-md-3">LastName:</div>
                        <div class="col-md-9">Due</div>
                    </div>

                <div class="row" id="featured">
                    <div class="col-sm-12">
                        <div class="page-header text-muted">
                            Photos
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-3">
                        <a href="#" class="thumbnail">
                            <img src="http://www.menslife.com/upload/iblock/c7b/Dasha1.jpg" alt="...">
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="#" class="thumbnail">
                            <img src="http://www.menslife.com/upload/iblock/c7b/Dasha1.jpg" alt="...">
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="#" class="thumbnail">
                            <img src="http://www.menslife.com/upload/iblock/c7b/Dasha1.jpg" alt="...">
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="#" class="thumbnail">
                            <img src="http://www.menslife.com/upload/iblock/c7b/Dasha1.jpg" alt="...">
                        </a>
                    </div>

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
                                    <form id="postForm" class="form-horizontal well" role="form" action="/addPost/<? echo $id; ?>">
                                        <textarea name="message" class="form-control" placeholder="Left your post"></textarea>
                                        <button class="btn btn-success pull-right" type="submit">Post</button>
                                    </form>
                                </div>
                            </div>

                            <div id="posts">
                                <?php foreach (array_reverse($posts) as $post)
                                    include(view . 'templates/post.php');
                                 ?>
                            </div>


                        </div><!-- /col-9 -->
                    </div><!-- /padding -->
                </div>
            </div>
        </div>

    </div>
</div>