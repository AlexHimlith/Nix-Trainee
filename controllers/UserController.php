<?php


namespace controllers;


use core\Controller;
use models\UserModel;
//use views\UserView;


class UserController extends Controller implements UserContInterface
{
    public function actionLogin()
    {
        $content = $this->viewObj->getFormLogin();//UserView::getFormLogin();
        $this -> viewObj -> render($content);
    }

    public function actionRegistration()
    {
        $content = $this->viewObj->getFormRegistration();//UserView::getFormRegistration();
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
        // проверить сессию на наличие авторизированного пользователя
        self::verifySession();
        //debug($_POST);
        // если массив POST не пуст
        if (!empty($_POST))
        {
            // вызвать обновление профиля
            $updated = UserModel::updateProfile();
        }
        // получить профиль пользователя и создать форму с его данными
        $user = UserModel::profileUser();
        $content = $this->viewObj->getFormProfile($user);//UserView::getFormProfile($user);

        // если было обновление профиля
        if (!empty($updated))
        {
            //добавить результаты
            $content .= "<br><p>$updated</p>";
        }
        $this -> viewObj -> render($content);
    }

    public function actionImage()
    {
        // проверить сессию на наличие авторизированного пользователя
        self::verifySession();
        //debug($_FILES);

        $load = '';
        // если был загружен файл
        if (!empty($_FILES))
        {
            // если картинка пользователя была обновлена
            if(UserModel::uploadImage())
            {
                // перейти на страницу профиля
                header("Location: /user/profile");
            }
            else
            {
                // сформировать сообщени о неудаче
                $load = "<br><p>File not loaded</p>";
            }

        }
        $content = $this->viewObj->getFormLoad() . $load;//UserView::getFormLoad() . $load;
        $this -> viewObj -> render($content);
    }

    public function actionExit()
    {
        $content = UserModel::exitUser();
        $this -> viewObj -> render($content);
    }
}