<?php


namespace models;


use core\Model;

class PostDbModel extends Model implements PostInterface
{
    /** Возвращает список всех постов из БД
     * @return false|\PDOStatement
     */
    public static function getList()
    {
        // получить подключение к бд
        $db = self::connect();
        //создать и віполнить запрос на обїединение
        $sql = "SELECT `posts`.*, `login`.`nick` FROM `posts` LEFT JOIN `login` ON (`posts`.`nick`=`login`.`id`)";
        return $db->pdo->query($sql);
    }

    /** Добавляет пост в бд
     * @return bool
     */
    public static function addPost()
    {
        // получить массив с постом
        $post = self::getNewPost();

        // если массив не пустой
        if ($post != [])
        {
            // получить подключение к бд
            $db = self::connect();

            // подготовить запрос
            $smtp = $db->pdo->prepare('INSERT INTO posts (`nick`, `date`, `title`, `text`) VALUES (:nick, :date, :title, :text)');

            // если запрос с переданным массивом не выполнен
            if (!$smtp->execute((array)$post)) {
                //print_r($smtp->errorInfo());
                // вернуть ложь
                return false;
            }
            // иначе все в порядке
            return true;
        }
        return false;
    }

}