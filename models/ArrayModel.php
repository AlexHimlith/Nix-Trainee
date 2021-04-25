<?php

namespace models;

use core\Model;

class ArrayModel extends Model implements Storage
{
    /** Возвращает весь массив постов из файла
     * @return mixed
     */
    public static function getList()
    {
        $file = ROOT . '/' . FILENAME;
        return json_decode(file_get_contents($file), TRUE);
    }

    /** Обрабатывает форму NewPost и добавляет новый пост в файл с массивом постов
     * @return bool
     */
    public static function addPost()
    {
        $post = self::getNewPost();


        //if ($post['nick'] == 1)
        //{
            $post['nick'] = '';
        //}

        $posts = self::getList();
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