<?php

namespace models;

class ArrayModel
{
    /** Возвращает весь массив постов из файла
     * @return mixed
     */
    public static function getListArray()
    {
        $file = ROOT . '/' . FILENAME;
        return json_decode(file_get_contents($file), TRUE);
    }

    /** Обрабатывает форму NewPost и добавляет новый пост в файл с массивом постов
     * @return bool
     */
    public static function addPost()
    {
        $post = [];
        if (isset($_POST['title']))
        {
            $title = htmlspecialchars($_POST['title']);
            $txt = htmlspecialchars($_POST['text']);

            $post = ['title'=>$title, 'text' => $txt];
        }

        $posts = ArrayModel::getListArray();
        $posts[] = $post;

        if(file_put_contents(ROOT . '/' . FILENAME, json_encode($posts)))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}