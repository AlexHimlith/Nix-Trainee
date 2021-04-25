<?php

namespace core;

use controllers\PostsController;
use controllers\UserController;
use models\UserModel;

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

    /** Возвращает путь запроса
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI']))
        {
            //echo $_SERVER['REQUEST_URI'];
            $route = ltrim($_SERVER['REQUEST_URI'],'/');

            return $route;
        }
    }

    /** Проверяет соответсвие запрошенного пути со списком правил
     * @param $uri string запрашиваемый путь
     * @return bool
     */
    private function matchRoute($uri)
    {
        //echo $uri;
        // для всех правил из списка, правило => путь
        foreach ($this->routes as $pattern => $route)
        {
            //echo $pattern;
            // если правило совпало с запрашиваемым путем
            if (preg_match("~$pattern~i", $uri, $matches))
            {
                //debug($matches);
                // разбираем совпадения на пары "контроллер-действие"
                foreach ($matches as $controller => $action)
                {
                    // если имя контроллера - это строка...
                    if (is_string($controller))
                    {
                        // ...то записываем в путь (местный) имя контроллера и действия
                        $route[$controller] = $action;
                    }
                }

                // если в списке правил не указанно действие...
                if (!isset($route['action']))
                {
                    // ...то по умолчанию ставим "индекс"
                    $route['action'] = 'index';
                }

                // записать "местный" путь в текущий путь класса
                $this->route = $route;

                //debug($this->route);
                // совпадение найдено
                return true;
            }
        }
        // совпадение не найдено
        return false;
    }

    /** Разбирает текущий запрос и запускает соответвующий контроллер-действие
     *
     */
    public function dispatch()
    {

        // получить запрос
        $uri = $this->getURI();

        //echo $uri;

        // если соотвествие с одним из спаска правил
        if ($this->matchRoute($uri))
        {
            //сформировать имя контроллера и действия
            $controller = 'controllers\\' . ucfirst($this->route['controller']) . 'Controller';
            $action = 'action' . ucfirst($this->route['action']);

            //echo $controller . '->' . $action;

            //$controller = 'controllers\\' . $controller;

            // если такой контроллер существует...
            if(class_exists($controller)){
                // ...создать его объект
                $controllerObj = new $controller($this->route['controller']);
                // если действие существует....
                if (method_exists($controllerObj, $action))
                {
                    // ...выполнить его
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

    }
}