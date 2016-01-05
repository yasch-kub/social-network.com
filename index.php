<?php
    session_start();
    define('root',dirname(__FILE__));
    define('view', root . '/application/view/');
    require_once(root.'/application/components/autoload.php');
    $router = new Router();
    $router->run();
