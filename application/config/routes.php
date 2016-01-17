<?php
    return [
        'adduser' => 'user/AddUser',
        'signin' => 'user/SignIn',
        'registration' => 'user/registration',
        'login' => 'user/login',
        '([0-9]+)/gallery' => 'user/gallery/$1',
        '([0-9]+)/friends' => 'user/friends/$1',
        'SaveWebCamImage' => 'user/SaveWebCamImage',
        'addinfo' => 'user/addinfo',
        '([0-9]+)' => 'user/profile/$1',
        'changeAvatar' => 'user/changeAvatar',
        'follow' => 'user/follow',
        'addPhotos' => 'user/addPhotos',
        'addPost/([0-9]+)' => 'user/addPost/$1',
        'getSlide' => 'user/getSlidePhoto',
        'messages' => 'user/messages',
        'dialog/([0-9]+)' => 'user/dialog/$1',
        'addComment/([0-9]+)/([0-9]+)' => 'user/addComment/$1/$2',
        'addMessage/([0-9]+)' => 'user/addMessage/$1',
        '' => 'user/view'
    ];