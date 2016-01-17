<style>
    <?php if(isset($userStyle['backgroundcolor'])): ?>
        body{
            background-color: <? echo $userStyle['backgroundcolor'] ?>;
        }
    <?php endif; ?>

    <?php if(isset($userStyle['usermenucolor'])): ?>
        .profile-usermenu ul li a {
            color: <? echo $userStyle['usermenucolor'] ?>;
        }
    <?php endif; ?>

    <?php if(isset($userStyle['usermenuhover'])): ?>
        .profile-usermenu ul li a:hover {
            color: <? echo $userStyle['usermenuhover'] ?>;
        }
    <?php endif; ?>


    <?php if(isset($userStyle['usermenuactive'])): ?>
        .profile-usermenu ul li.active a {
            color: <? echo $userStyle['usermenuactive'] ?>;
            border-left: 2px solid <? echo $userStyle['usermenuactive'] ?>;
        }
    <?php endif; ?>
</style>
<div class="container">
    <div class="row profile">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="profile-sidebar">
                <div
                    <?php if($id == UserModel::getUserId()): ?>
                        id="avatarDropzone"
                    <?php endif; ?>
                    class="profile-userpic">

                    <div class="dropzone">
                        <i class="fa fa-cloud-download fa-3x"></i>
                        <b>Drop file here</b>
                    </div>

                    <img src="<? echo '/application/data/users/' . $id . '/' . $user['avatar'][0]; ?>"
                         class="img-responsive" alt="">
                </div>
                <div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title">dfdfgdfgfdgdf</h3><div class="popover-content">sdgsdgsdfgdsgdf</div></div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <? echo $user['name'] . ' ' . $user['surname'] ?>
                    </div>
                    <div class="profile-usertitle-job">
                        Developer
                    </div>
                </div>
                <div class="profile-userbuttons">

                    <?php if(UserModel::getUserId() != $id): ?>
                        <?php if(!in_array($id, UserModel::getFollowers(UserModel::getUserId()))): ?>
                            <button value="<? echo $id; ?>" id="follow" type="submit" class="btn btn-success btn-sm">Follow</button>
                        <?php endif; ?>
                        <button id="message" type="button" class="btn btn-danger btn-sm">Message</button>
                    <?php endif; ?>
                </div>
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="<? echo $menuClass[0]; ?>">
                            <a href="/">
                                <i class="glyphicon glyphicon-home"></i>
                                Home
                            </a>
                        </li>
                        <li class="<? echo $menuClass[1]; ?>">
                            <a href="/<? echo $id; ?>/friends">
                                <i class="fa fa-users"></i>
                                Friends
                            </a>
                        </li>

                        <li class="<? echo $menuClass[2]; ?>">
                            <a href="/messages">
                                <i class="fa fa-envelope"></i>
                                Messages
                            </a>
                        </li>
                        <li class="<? echo $menuClass[3]; ?>">
                            <a href="/<? echo $id; ?>/gallery">
                                <i class="fa fa-picture-o"></i>
                                Photos
                            </a>
                        </li>
                        <li class="<? echo $menuClass[4]; ?>">
                            <a href="/accountSetting">
                                <i class="glyphicon glyphicon-cog"></i>
                                Account Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="profile-content">
                <?php include_once(view . $profile_content)?>
            </div>
        </div>
    </div>
</div>