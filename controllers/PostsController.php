<?php


namespace controllers;


//use models\ArrayModel;
use core\Controller;
use models\DbModel;
use views\PostsView;

class PostsController extends Controller
{
    public function actionIndex()
    {
        /*$posts = ArrayModel::getList();*/
        $posts = DbModel::getList();
        $content = $this -> viewObj -> getAllPost($posts);
        $this->viewObj -> render($content);
    }

    public function actionNew()
    {
        $content = PostsView::getFormNewPost();
        $this -> viewObj -> render($content);
    }

    public function actionAddPost()
    {
        /*if(ArrayModel::addPost())*/
        if (DbModel::addPost())
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