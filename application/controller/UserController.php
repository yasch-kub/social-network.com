<?php
class UserController
{
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
        exit(UserModel::AddUser($_POST['reg_fullname'], $_POST['reg_email'] , $_POST['reg_password']));
    }
}