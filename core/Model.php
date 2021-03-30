<?php


namespace core;


class Model
{
    public static function getNewPost()
    {
        if (isset($_POST['title']))
        {
            $title = htmlspecialchars($_POST['title']);
            $txt = htmlspecialchars($_POST['text']);

            date_default_timezone_set('Europe/Kiev');
            $date = date('d-m-Y H:i:s');

            //Временно. Пролучить ник после авторизации!
            $nick = 1;

            return ['nick' => $nick, 'date' => $date, 'title' => $title, 'text' => $txt];
        }
        return [];
    }

}