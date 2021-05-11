<?php


namespace controllers;

use core\Controller;
use views\MainView;

class MainController extends Controller implements MainContInterface
{
    public function actionIndex()
    {
        $content = $this->viewObj->getMain();
        $this -> viewObj -> render($content);
    }
}