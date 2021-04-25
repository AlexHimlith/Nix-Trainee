<?php


namespace controllers;


use core\Controller;
use models\UserModel;
use views\UserView;


class UserController extends Controller
{
    public function actionLogin($end_session = false)
    {
        $content = UserView::getFormLogin($end_session);
        $this -> viewObj -> render($content);
    }

    public function actionRegistration()
    {
        $content = UserView::getFormRegistration();
        $this -> viewObj -> render($content);
    }

    public function actionSignin()
    {
        $content = UserModel::loginUser();
        $this -> viewObj -> render($content);
    }

    public function actionNewUser()
    {
        //if (!empty($_POST['']))
        $content = UserModel::newUser();
        $this -> viewObj -> render($content);
    }

    public function actionExit()
    {
        $content = UserModel::exitUser();
        $this -> viewObj -> render($content);
    }
}