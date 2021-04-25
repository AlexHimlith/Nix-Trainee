<?php


namespace models;


use core\Model;

class DbModel extends Model implements Storage
{
    public static function getList()
    {
        $db = self::connect();
        $sql = "SELECT `posts`.*, `login`.`nick` FROM `posts` LEFT JOIN `login` ON (`posts`.`nick`=`login`.`id`)";
        return $db->pdo->query($sql);
    }

    public static function addPost()
    {
        $post = self::getNewPost();
        //debug($post);

        if ($post != [])
        {
            $db = self::connect();
            //debug($db);
            /*extract($post);
            echo $nick . '<br>';
            echo $date . '<br>';
            echo $title . '<br>';
            echo $text . '<br>';*/

            $smtp = $db->pdo->prepare('INSERT INTO posts (`nick`, `date`, `title`, `text`) VALUES (:nick, :date, :title, :text)');

            if (!$smtp->execute((array)$post)) {
                print_r($smtp->errorInfo());
                return false;
            }
            return true;
        }
        return false;
    }

}