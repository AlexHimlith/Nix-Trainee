<?php


namespace models;


use core\Model;

class DbModel extends Model implements Storage
{
    protected $pdo;
    protected static $inctance;

    protected function __construct()
    {
        require_once ROOT . '/config/db.php';
        $this->pdo = new \PDO($dsn, $user, $pass, $opt);
    }

    public static function connect()
    {
        if (self::$inctance === null)
        {
            self::$inctance = new self;
        }
        return self::$inctance;
    }

    public static function getList()
    {
        $db = self::connect();
        return $db -> pdo -> query('SELECT nick, date, title, text from posts');
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

            $smtp = $db->pdo->prepare('INSERT INTO posts (nick, date, title, text) VALUES (:nick, :date, :title, :text)');

            if (!$smtp->execute((array)$post)) {
                print_r($smtp->errorInfo());
                return false;
            }
            return true;
        }
        return false;
    }

}