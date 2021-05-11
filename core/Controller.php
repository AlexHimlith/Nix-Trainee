<?php


namespace core;

class Controller
{

    public $viewObj;

    function __construct($viewObj)
    {
        // запустить сессию
        session_start();
        // сформировать название обьекта Вида
        $viewObj = ucwords($viewObj);
        $viewObj = 'views\\'. $viewObj . 'View';
        // создать обьект Вида
        $this->viewObj = new $viewObj;
    }

    /** Проверяет наличие переменных в текущей сессии
     *
     */
    public static function verifySession()
    {
        // если идентификатор пользователя пуст
        if (empty($_SESSION['id']))
        {
            // перейти на страну авторизации
            header("Location: /user/login");
        }
    }
}