<?php
class UserController
{
    public static function ActionView()
    {
        if (UserModel::isLogedIn())
            header('Location: /' . $_SESSION['id']);
        else
            header('Location: ' . '/login');
    }

    public static function ActionLogin()
    {
        $view = 'templates/login.php';
        $links = ['authorization.css'];
        $scripts = ['authorization.js'];
        include_once(view . '/templates/template.php');
    }

    public static function ActionRegistration()
    {
        $view = 'templates/registration.php';
        $links = ['authorization.css'];
        $scripts = ['authorization.js'];
        include_once(view . '/templates/template.php');
    }

    public static function ActionAddUser()
    {
        $result = UserModel::AddUser($_POST['reg_fullname'], $_POST['reg_email'], $_POST['reg_password']);
        exit($result);
    }

    public static function ActionSignIn()
    {
        $result = UserModel::Login($_POST['lg_username'], $_POST['lg_password']);
        if ($result) {
            $_SESSION['id'] = $result;
            exit(json_encode(true));
        } else
            exit(json_encode(false));
    }

    public static function ActionProfile($id)
    {

        $view = 'templates/userProfile.php';
        $profile_content = 'templates/main.php';
        $links = ['userProfile.css'];
        $scripts = ['dragAndDropDownload.js', 'addPost.js', 'slider.js', 'addInform.js', 'follow.js'];
        $user = UserModel::getInfo($id);
        $posts = UserModel::getPosts($id);
        include_once(view . '/templates/template.php');
    }

    public static function ActionChangeAvatar()
    {
        $path = '/application/data/users/' . UserModel::getUserId() . '/';
        $images = self::fileUpload($path);
        UserModel::changeAvatar($images[0]);
        $images[0] = $path . $images[0];
        exit(json_encode($images));
    }

    public static function ActionAddPhotos()
    {
        $path = '/application/data/users/' . UserModel::getUserId() . '/photos/';
        $images = self::fileUpload($path);
        UserModel::addPhotos($images);
        for ($i = 0; $i < count($images); $i++) {
            $images[$i] = $path . $images[$i];
        }
        exit(json_encode($images));
    }

    public static function ActionAddPost($userId)
    {
        $post = UserModel::addPost(self::clear($_POST['message']), $userId);
        include_once(view . 'templates/post.php');
    }

    public static function ActionGetSlidePhoto()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        exit(json_encode(UserModel::getPhotosByNum($data['id'], $data['num'], $data['direction'])));
    }

    public static function ActionGallery($id)
    {
        $user = UserModel::getInfo($id);
        $photos = UserModel::getAllPhotos($id);
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/gallery.php';
        $links = ['gallery.css', 'userProfile.css'];
        $scripts = ['gallery.js', 'dragAndDropDownload.js', 'follow.js'];
        include_once(view . '/templates/template.php');
    }

    public static function actionFriends($id)
    {
        $user = UserModel::getInfo($id);
        $photos = UserModel::getAllPhotos($id);
        $followers = UserModel::getFollowersInfo($id);
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/friends.php';
        $links = ['userProfile.css'];
        $scripts = ['dragAndDropDownload.js', 'follow.js'];
        include_once(view . '/templates/template.php');
    }

    public static function actionAddInfo()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        exit(json_encode(UserModel::addInformation($data['info'], $data['value'])));
    }

    public static function clear($value)
    {
        return htmlspecialchars(strip_tags(trim($value)));
    }

    public static function fileUpload($path)
    {
        $images = [];
        foreach ($_FILES['files']['name'] as $index => $name)
            if ($_FILES['files']['error'][$index] == UPLOAD_ERR_OK
                and move_uploaded_file($_FILES['files']['tmp_name'][$index], root . $path . $name)
            ) {
                $images[] = $name;
            }

        return $images;
    }

    public static function actionFollow()
    {
        $follower_id = file_get_contents('php://input');
        if (UserModel::addFolowers($follower_id))
            exit ('ok');
        else
            exit('fail');
    }

    public function actionMessages()
    {
        $id = UserModel::getUserId();
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/message.php';
        $links = ['userProfile.css', 'messages.css'];
        $scripts = ['dragAndDropDownload.js', 'follow.js'];
        $user = UserModel::getInfo($id);
        include_once(view . '/templates/template.php');
    }

    public static function actionDialog()
    {
        $id = UserModel::getUserId();
        $user = UserModel::getInfo($id);
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/dialog.php';
        $links = ['userProfile.css', 'dialog.css'];
        $scripts = ['dragAndDropDownload.js', 'follow.js'];
        include_once(view . '/templates/template.php');
    }
}