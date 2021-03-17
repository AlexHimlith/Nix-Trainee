<?php


namespace controllers;


use models\ArrayModel;
use views\PostView;

class PostsController
{
    public function actionIndex()
    {
        $posts = ArrayModel::getListArray();
        $content = PostView::getAllPost($posts);

        include DEFAULT_VIEW;
    }

    public static function actionNew()
    {
        $content = PostView::getFormNewPost();

        include DEFAULT_VIEW;
    }

    public static function actionAddPost()
    {
        $path = PROJECT_PATH;
        if(ArrayModel::addPost())
        {
            $content = "<p>Your Post Has Been Added</p>
                        <a href=$path/posts>Return</a>";
        }
        else
        {
            $content = "<p>Your Post Has Not Been Added</p>";
        };

        include DEFAULT_VIEW;
    }
}