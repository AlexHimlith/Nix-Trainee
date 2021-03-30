<?php


namespace controllers;


use models\ArrayModel;
use models\DbModel;
use views\PostView;
use views\View;

class PostsController
{
    public function actionIndex()
    {
        /*$posts = ArrayModel::getList();*/
        $posts = DbModel::getList();
        $content = PostView::getAllPost($posts);
        View::render($content);
    }

    public static function actionNew()
    {
        $content = PostView::getFormNewPost();
        View::render($content);
    }

    public static function actionAddPost()
    {
        $path = PROJECT_PATH;
        /*if(ArrayModel::addPost())*/
        if (DbModel::addPost())
        {
            $content = "<p>Your Post Has Been Added</p>
                        <a href=$path/posts>Return</a>";
        }
        else
        {
            $content = "<p>Your Post Has Not Been Added</p>";
        };

        View::render($content);
    }
}