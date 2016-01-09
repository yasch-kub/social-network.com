<div class="container">
    <div class="row profile">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div id="avatarDropzone" class="profile-userpic">
                    <img src="<? echo '/application/data/users/' . UserModel::getUserId() . '/' .$user['avatar'][0]; ?>" class="img-responsive" alt="">
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
                                    <div class="well">
                                        <form class="form-horizontal" role="form">
                                            <h4>What's New</h4>
                                            <div class="form-group" style="padding:14px;">
                                                <textarea class="form-control" placeholder="Update your status"></textarea>

                                            </div>
                                            <button class="btn btn-success pull-right" type="button">Post</button>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-10">
                                    <p c>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    <p class="text-muted">
                                        1 hour ago •
                                        <a href="#" class="text-muted">Marcus Doe</a>
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
                                    <a href="#" class="pull-right"><img src="http://www.menslife.com/upload/iblock/c7b/Dasha1.jpg" class="img-circle"></a>
                                </div>
                            </div>

                            <div class="row divider">
                                <div class="col-sm-12"><hr></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-10">
                                    <h3>This is Some Awesome Featured Content</h3>
                                    <h4>
                                        <small class="text-muted">1 hour ago • <a href="#" class="text-muted">Marcus Doe</a></small>
                                    </h4>
                                </div>
                                <div class="col-sm-2">
                                    <a href="#" class="pull-right"><img src="http://www.menslife.com/upload/iblock/c7b/Dasha1.jpg" class="img-circle"></a>
                                </div>
                            </div>
                            <div class="row divider">
                                <div class="col-sm-12"><hr></div>
                            </div>

                        </div><!-- /col-9 -->
                    </div><!-- /padding -->
                </div>
            </div>
        </div>

    </div>
</div>