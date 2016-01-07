<?php
    return [
        'adduser' => 'user/AddUser',
        'signin' => 'user/SignIn',
        'registration' => 'user/registration',
        'login' => 'user/login',
        '([0-9]+)' => 'user/profile/$1',
        '' => 'user/view'
    ];