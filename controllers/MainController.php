<?php


namespace controllers;


class MainController
{
    public function actionIndex()
    {
        $content = 'MainController->actionIndex';
        include DEFAULT_VIEW;
    }
}