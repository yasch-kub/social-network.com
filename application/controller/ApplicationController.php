<?php

class ApplicationController
{
    public static function ActionRules()
    {
        $id = UserModel::getUserId();
        $dictionary = UserModel::getLangArray();
        $menuClass = [0 => 'active', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''];
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/rules.php';
        $links = ['userProfile.css', 'webcam.css', 'rules.css'];
        $scripts = ['dragAndDropDownload.js', 'addPost.js', 'MediaAPI.js'];
        $user = UserModel::getInfo($id);

        include_once(view . '/templates/template.php');
    }
}