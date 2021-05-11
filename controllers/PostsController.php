<?php


namespace controllers;


//use models\ArrayModel;
use core\Controller;
use models\PostDbModel;
use views\PostsView;

class PostsController extends Controller implements PostContInterface
{
    public function actionIndex()
    {
        // получить массив с постами
        /*$posts = ArrayModel::getList();*/
        $posts = PostDbModel::getList();

        $content = $this -> viewObj -> getAllPost($posts);
        $this->viewObj -> render($content);
    }

    public function actionNew()
    {
        // проверить сессию на наличие авторизированного пользователя, запретив метода из адресной строки
        self::verifySession();

        $content = $this->viewObj->getFormNewPost();//PostsView::getFormNewPost();
        $this -> viewObj -> render($content);
    }

    public function actionAddPost()
    {
        // проверить сессию на наличие авторизированного пользователя, запретив метода из адресной строки
        self::verifySession();

        // если новый пост был успешно добавлен
        /*if(ArrayModel::addPost())*/
        if (PostDbModel::addPost())
        {
            $content = "<p>Your Post Has Been Added</p>
                        <a href='/posts'>Return</a>";
        }
        else
        {
            $content = "<p>Your Post Has Not Been Added</p>";
        };

        $this -> viewObj -> render($content);
    }
}