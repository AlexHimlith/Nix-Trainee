<?php


namespace core;


class Model
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

    public static function getNewPost()
    {
        if (isset($_POST['title']))
        {
            $title = htmlspecialchars($_POST['title']);
            $txt = htmlspecialchars($_POST['text']);

            date_default_timezone_set('Europe/Kiev');
            $date = date('d-m-Y H:i:s');

            $nick = $_SESSION['id'];

            return ['nick' => $nick, 'date' => $date, 'title' => $title, 'text' => $txt];
        }
        return [];
    }

    protected static function updateOne($table, $id, $field, $value)
    {
        $db = self::connect();
        $smtp = $db->pdo->prepare("UPDATE $table SET $field = :val WHERE `id` = $id");
        $smtp->bindValue('val', $value);
        if (!$smtp->execute())
        {
            return false;
        }
        return true;
    }
}