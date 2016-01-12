<?php
class UserController
{
    public static function ActionView()
    {
        if(UserModel::isLogedIn())
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
        $result = UserModel::AddUser($_POST['reg_fullname'], $_POST['reg_email'] , $_POST['reg_password']);
        exit($result);
    }

    public static function ActionSignIn()
    {
        $result = UserModel::Login($_POST['lg_username'] , $_POST['lg_password']);
        if ($result) {
            $_SESSION['id'] = $result;
            exit(json_encode(true));
        }
        else
            exit(json_encode(false));
    }

    public static function ActionProfile($id){

        $view = 'templates/userProfile.php';
        $links = ['userProfile.css'];
        $scripts = ['dragAndDropDownload.js', 'addPost.js', 'slider.js'];
        $user = UserModel::getInfo($id);
        $posts = UserModel::getPosts($id);
        include_once(view . '/templates/template.php');
    }

    public static function ActionChangeAvatar()
    {
        foreach ($_FILES['files']['name'] as $index => $name)
            if($_FILES['files']['error'][$index] == UPLOAD_ERR_OK
                and move_uploaded_file($_FILES['files']['tmp_name'][$index], root . '/application/data/users/' .UserModel::getUserId(). '/' . $name))
            {
                UserModel::changeAvatar($name);
                $name = '/application/data/users/' .UserModel::getUserId(). '/' . $name;
                exit($name);
            }
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
        exit(json_encode(UserModel::getPhotosByNum($data['id'], $data['num'])));
    }

    public static function clear($value)
    {
        return htmlspecialchars(strip_tags(trim($value)));
    }

}