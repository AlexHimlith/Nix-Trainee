<?php


namespace core;


class View
{
    public $title;
    public $header;

    function __construct()
    {
        // подключить конфигурацию шаблона
        require 'config/layout.php';
        $this->title = $title;
        $this->header = $header;
    }

    /** Выводит титул страницы
     *
     */
    public function getTitle()
    {
        echo "<title>$this->title</title>";
    }

    /** Формируте "шапку" страницы
     * @return string
     */
    public function getHeader()
    {
        // если в текущей сессии есть переменная nickБ т.е. произошла авторизация
        if (!empty($_SESSION['nick']))
        {
            // задать данные для вывода ника пользователя и ссылки на выход
            $auth = $_SESSION['nick'];
            $route = '/user/exit';
        }
        else
        {
            // иначе задать ссылку на авторизацию
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

    /** Формирует меню страницы
     * @return string
     */
    public function getMenu()
    {
        // если задан nick в сессии (пользователь авторизован)
        if (!empty($_SESSION['nick']))
        {
            // задать ссылку на страницу профиля
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
                <a id='prof' href='$route'>$profile</a>
                </nav>";
    }

    /** Формирует подвал страницы
     * @return string
     */
    public function getFooter()
    {
        return "<footer>
                    <h2>FOOOTER</h2>
                </footer>";
    }

    /** Подключает шаблон с заданным сонтентом
     * @param $content
     * @param string $layout
     */
    public function render($content, $layout = DEFAULT_VIEW)
    {
        include $layout;
    }
}