<?php


namespace core;


class View
{
    public $title;
    public $header;

    function __construct()
    {
        require 'config/layout.php';
        $this->title = $title;
        $this->header = $header;
    }

    public function getTitle()
    {
        echo "<title>$this->title</title>";
    }

    public function getHeader()
    {
        if (!empty($_SESSION['nick']))
        {
            $auth = $_SESSION['nick'];
            $route = '/user/exit';
        }
        else
            {
                $auth = 'Login';
                $route = '/user/login';
            }
        return
            "<header>
                <div>&nbsp;</div>
                <h1> $this->header </h1>
                <div><a href='$route'>$auth</a></div>
            </header>";
    }

    public function getMenu()
    {
        //$path = PROJECT_PATH;
        if (!empty($_SESSION['nick']))
        {
            $profile = 'Profile';
            $route = '/user/profile';
            $newpost = "<a href='/posts/new'>New Post</a>";
        }
        else
        {
            $profile = '';
            $route = '';
            $newpost = '';
        }
        return "<nav>
                <a href='/'>Home</a>
                <a href='/posts'>Posts</a>
                $newpost
                <a id='login' href='$route'>$profile</a>
                </nav>";
    }

    public function getFooter()
    {
        return "<footer>
                    <h2>FOOOTER</h2>
                </footer>";
    }

    public function render($content, $layout = DEFAULT_VIEW)
    {
        include $layout;
    }
}