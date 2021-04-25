<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //session_start();

    //технический файл
    require_once 'functions.php';

    // Путь папки проекта, задать '' если проект не лежит в отдельной папке
    define('PROJECT_PATH','');
    //Корень
    define('ROOT', __DIR__ . PROJECT_PATH);
    // Файлс с массивом
    define('FILENAME', 'posts.txt');
    // Вид по умолчанию
    define('DEFAULT_VIEW', ROOT . '/views/layout/default.php');

    //автозагрузка классов
    spl_autoload_register(function ($class)
    {
        $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
        /*echo $class . '<br>';
        echo $file . '<br>';*/
        if(file_exists($file))
        {
            require_once $file;
        }
    });

    //запуск роутера
    $router = new \core\Router();
    $router -> dispatch();

