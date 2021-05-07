<?php


namespace controllers;


use core\Controller;
use models\UserModel;
use views\UserView;


class UserController extends Controller
{
    public function actionLogin(/*$end_session = false*/)
    {
        $content = UserView::getFormLogin();
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
        $content = UserModel::newUser();
        $this -> viewObj -> render($content);
    }

    public function actionProfile()
    {
        if (!empty($_POST))
        {
            $updated = UserModel::updateProfile();
        }
        $user = UserModel::profileUser();
        $content = UserView::getFormProfile($user) ;
        if (!empty($updated))
        {
            $content .= "<br><p>$updated</p>";
        }
        $this -> viewObj -> render($content);
    }

    public function actionImage()
    {
        //debug($_FILES);

        $load = '';
        if (!empty($_FILES))
        {
            if(UserModel::uploadImage())
            {
                /*$load = "<br><p>File loaded</p>";*/
                header("Location: /user/profile");
            }
            else
                {
                    $load = "<br><p>File not loaded</p>";
                }

        }
        $content = UserView::getFormLoad() . $load;
        $this -> viewObj -> render($content);
    }

    public function actionExit()
    {
        $content = UserModel::exitUser();
        $this -> viewObj -> render($content);
    }
}