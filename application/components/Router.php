<?php

class Router
{
    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = include(root . '/application/config/routes.php');
    }

    /**
     *
     */
    public function run()
	{
        $isCorrectPage = false;
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $pattern => $path)
            if  (preg_match("~$pattern~", $uri))
            {
                $internalUri = preg_replace("~$pattern~", $path, $uri);
                $segments = explode('/', $internalUri);

                $controllerName = array_shift($segments) . "Controller";

                $actionName = array_shift($segments);
                $actionName = 'Action' . $actionName;

                $parameters = $segments;

                $controllerFile = root . '/application/controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile))
                    include_once $controllerFile;

                if (method_exists($controllerName, $actionName))
                {
                    call_user_func_array(array($controllerName, $actionName), $parameters);
                    $isCorrectPage = true;
                    break;
                }
            }
        /*
        if (!$isCorrectPage)
            self::error404();
        */
    }

    /**
     *
     */
    private function error404()
    {
        /*
        header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
        header('Status: 404 Not Found');
        include_once root . '/application/views/errors/page404.php';
        */
    }
}