<?php
class UserController
{
    public static function ActionView()
    {
        if(UserModel::isLogedIn())
            echo 'Main page';
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
            $_SESSION['login'] = true;
            exit(json_encode(true));
        }
        else
            exit(json_encode(false));
    }
}