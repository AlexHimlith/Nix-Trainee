<?php


namespace core;


class Model
{
    protected $pdo;
    protected static $inctance;

    protected function __construct()
    {
        // подключить конфигурацию базы
        require_once ROOT . '/config/db.php';
        // создать обьект PDO
        $this->pdo = new \PDO($dsn, $user, $pass, $opt);
    }

    /** Возвращает Model с подключенным обьектом PDO
     * @return Model
     */
    public static function connect()
    {
        // если экземпляр не существует
        if (self::$inctance === null)
        {
            // создать обект
            self::$inctance = new self;
        }
        // и вернуть либо созданный ранее, либо новый
        return self::$inctance;
    }

    /** Возвращает массив с данными и содержанием нового поста
     * @return array
     */
    public static function getNewPost()
    {
        // если POST-массив содержит заголовок поста
        if (isset($_POST['title']))
        {
            // забирать заголовок и содержание поста
            $title = htmlspecialchars($_POST['title']);
            $txt = htmlspecialchars($_POST['text']);

            // установить временной пояс
            date_default_timezone_set('Europe/Kiev');
            // получить текущую дату и время
            $date = date('d-m-Y H:i:s');

            // получить идентифекатор пользователя из сессии (не ник!)
            $id = $_SESSION['id'];

            // вернуть массив с постом
            return ['nick' => $id, 'date' => $date, 'title' => $title, 'text' => $txt];
        }
        // иначе вернуть пустышку
        return [];
    }

    /** Обновляет содержание заданного поля в заданной таблице по идентификатору записи
     * @param $table string имя таблицы
     * @param $id int идентификатор записи
     * @param $field string
     * @param $value записываемые данные
     * @return bool
     */
    protected static function updateOne($table, $id, $field, $value)
    {
        // получить соединение с базой
        $db = self::connect();
        // подготовить запрос на обновление и новое значение поля
        $smtp = $db->pdo->prepare("UPDATE $table SET $field = :val WHERE `id` = $id");
        $smtp->bindValue('val', $value);
        // если запрос НЕ выполнен успешно
        if (!$smtp->execute())
        {
            // вернуть ложь
            return false;
        }
        // иначе вернуть истину
        return true;
    }
}