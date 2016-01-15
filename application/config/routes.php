<?php
    return [
        'adduser' => 'user/AddUser',
        'signin' => 'user/SignIn',
        'registration' => 'user/registration',
        'login' => 'user/login',
        '([0-9]+)/gallery' => 'user/gallery/$1',
        '([0-9]+)/friends' => 'user/friends/$1',
        'addinfo' => 'user/addinfo',
        '([0-9]+)' => 'user/profile/$1',
        'changeAvatar' => 'user/changeAvatar',
        'addPost/([0-9]+)' => 'user/addPost/$1',
        'getSlide' => 'user/getSlidePhoto',

        '' => 'user/view'
    ];