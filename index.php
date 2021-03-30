<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once 'functions.php';

    //require_once 'Posts.php';

    /*require_once 'core/Router.php';
    require_once 'controllers/PostsController.php';
    require_once 'controllers/MainController.php';*/

    // Путь папки проекта, задать '' если проект не лежит в отдельной папке
    define('PROJECT_PATH','');
    //Корень
    define('ROOT', __DIR__ . PROJECT_PATH);
    // Файлс с массивом
    define('FILENAME', 'posts.txt');
    // Вид по умолчанию
    define('DEFAULT_VIEW', ROOT . '/views/layout/default.php');

    spl_autoload_register(function ($class)
    {
        $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
        /*echo $class . '<br>';
        echo $file . '<br>';*/
        if(file_exists($file))
        {
            require_once $file;
        }
        /*require_once $class . '.php';*/
    });

    $router = new \core\Router();
    $router -> dispatch();

