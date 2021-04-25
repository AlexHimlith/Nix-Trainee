<?php


namespace controllers;

use core\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        $content = 'MainController->actionIndex';
        $this -> viewObj -> render($content);
    }
}