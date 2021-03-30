<?php


namespace controllers;


use models\DbModel;
//use views\PostView;
use views\View;

class MainController
{
    public function actionIndex()
    {
        $content = /*DbModel::getList();*/'MainController->actionIndex';
        View::render($content);
    }
}