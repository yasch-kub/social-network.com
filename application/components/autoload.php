<?php
function __autoload($class){
    $paths = array('/application/components/',
        '/application/controller/',
        '/application/model/');
    foreach ($paths as $path){
        $file = root.$path.$class.'.php';
        if (file_exists($file)){
            require_once($file);
            break;
        }
    }
}