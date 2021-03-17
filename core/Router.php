<?php

namespace core;

use controllers\PostsController;

class Router
{
    /** Массив путей для рутера
     * @var mixed
     */
    private $routes = [];

    /** Текущий путь
     * @var array
     */
    private $route = [];

    public function __construct()
    {
        // Подключить массив с путями
        $this->routes = include(ROOT . '/config/routes.php');
    }

    /** Возвращает путь запроса без папки проекта (если таковая имеется) и index.php (разобраться, почему запихивает, если набрать в строке запроса)
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI']))
        {
            $route = str_replace('index.php/','', $_SERVER['REQUEST_URI']);
            $route = str_replace('index.php','', $route);
            $route = str_replace(PROJECT_PATH . '/','', $route);

            return $route;
        }
    }

    private function matchRoute($uri)
    {
        foreach ($this->routes as $pattern => $route)
        {
            //echo $pattern;
            if (preg_match("~$pattern~i", $uri, $matches))
            {
                //debug($matches);
                foreach ($matches as $controller => $action)
                {
                    if (is_string($controller))
                    {
                        $route[$controller] = $action;
                    }
                }

                if (!isset($route['action']))
                {
                    $route['action'] = 'index';
                }

                $this->route = $route;

                //debug($this->route);

                return true;
            }
        }
        return false;
    }

    public function dispatch()
    {
        $uri = $this->getURI();

        //echo $uri;

        if ($this->matchRoute($uri))
        {
            $controller = ucfirst($this->route['controller']) . 'Controller';
            $action = 'action' . ucfirst($this->route['action']);

            //echo $controller . '->' . $action;

            $controller = 'controllers\\' . $controller;

            if(class_exists($controller)){
                $controllerObj = new $controller;
                if (method_exists($controllerObj, $action))
                {
                    $controllerObj->$action();
                }
                else
                    {
                        echo "Action <b>{$controller}->{$action}</b> Not Found";
                    }
            }
            else
                {
                    echo "Controller <b>{$controller}</b> Not Found";
                }
        }
        else
            {
                http_response_code(404);
                include '404.html';
            }



        /*foreach ($this->routes as $uriPattern => $path)
        {
            //echo 'uriPattern: ' . debug($uriPattern);
            //echo 'path: ' . debug($path);

            if (preg_match("~^($uriPattern)$~i", $uri))//, $matches))
            {
                $segments = explode('/', $path);

                $controllerName = ucfirst(array_shift($segments) . 'Controller');

                $actionName = 'action' . ucfirst(array_shift($segments));

                $controllerFile = 'controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile))
                {
                    require_once $controllerFile;
                }

                $controllerObj = new $controllerName();
                $result = $controllerObj->$actionName();
                if ($result != null)
                {
                    break;
                }
            }
        }*/

        /*$d = 'Query_string: ' . $_SERVER['QUERY_STRING'] . '<br>';
        $d .= 'Request_uri: ' . $_SERVER['REQUEST_URI'] . '<br>';
        $d .= 'After: ' . $q . '<br>';
        $d .= 'GET: ' . $_GET['r'] . '<br>';
        return $d;*/


    }
}