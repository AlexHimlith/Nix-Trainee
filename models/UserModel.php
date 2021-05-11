<?php


namespace models;


class UserModel extends \core\Model implements UserInterface
{
    /** Возвращает список пользователей с заданным ником и электронной почтой
     * @param $nick string
     * @param $email string
     * @return mixed
     */
    protected static function getUser($nick, $email)
    {
        // метод защишен, но не вынесен в Model, чтобы его не наследовали другие модели

        // получить соединение с бд
        $db = self::connect();
        // подготовить запрос с отбором по nick или e-mail
        $smtp = $db->pdo->prepare("SELECT * FROM `login` WHERE `nick` = :nick OR `email` = :email");
        $smtp->bindValue('nick', $nick);
        $smtp->bindValue('email', $email);
        // выполнить запрос и вернуть преобразованным в массив
        $smtp->execute();
        return $smtp->fetch();
    }

    /** Возвращает данные профиля пользователи по его идентификатору
     * @param $id
     * @return mixed
     */
    protected static function getProfile($id)
    {
        // метод защишен, но не вынесен в Model, чтобы его не наследовали другие модели

        // получить соединение с бд
        $db = self::connect();

        // подготовить запрос (в принципе не обязательно, потому как идентификатор получается не от пользователя)
        // выборка ведется по идентификатору пользователя, а не его профиля
        //$query = "SELECT `users`.*, `login`.`nick`,`mail` FROM `users` LEFT JOIN `login` ON (`users`.`id_log`=`login`.`id`) WHERE `login`.`id` = :idlog";
        $query = "SELECT * FROM `users` WHERE `id_log` = :id";
        $user = $db->pdo->prepare($query);
        $user->bindValue('id', $id);
        // выполнить и передать преобразованным в массив
        $user->execute();
        return $user->fetch();
    }

    /** Добавляет нового пользователя в бд и авторизует его
     * @return string
     */
    public static function newUser()
    {
        //debug($_POST);
        // если поля в массиве POST не пусты и пароли совпадают
        if (!empty($_POST['nick']) && !empty($_POST['email']) && !empty($_POST['pass1']) && ($_POST['pass1'] === $_POST['pass2']))
        {
            // забрать данные из массива POST
            $nick = trim(htmlspecialchars($_POST['nick']));
            $email = trim(htmlspecialchars($_POST['email']));
            $pass1 = trim(htmlspecialchars($_POST['pass1']));

            // проверить, если в обход проверки на стороне клиента в поле ника была введена электронная почта
            if (strpos($nick, '@')){
                return "<p>Error! Nickname can consist of English characters and numbers.</p><br><p><a href='/user/registration'>Back</a></p>";
            }

            // поиск пользователей с введенными ником или почтой
            $user = self::getUser($nick, $email);

            // если хотя бы один такой пользователь найден
            if ($user)
            {
                // сообщить, что или почта уже заняты
                return "<p>This nick or e-mail already exists.<p><br><p><a href='/user/registration'>Back</a></p>";
            }
            // хешировать пароль
            $pass = password_hash($pass1, PASSWORD_DEFAULT);

            // получить соединение с бд
            $db = self::connect();
            // подготовить запрос на добавление
            $smtp = $db->pdo->prepare("INSERT INTO `login` (`nick`, `email`, `pass`) VALUES (:nick, :mail, :pass)");
            $smtp->bindValue('nick', $nick);
            $smtp->bindValue('mail', $email);
            $smtp->bindValue('pass', $pass);
            // если выполнение запроса прошло успешно
            if ($smtp->execute())
            {
                // занести в сессию данные авторизированного пользователя
                $_SESSION['nick'] = $nick;
                $_SESSION['id'] = $db->pdo->lastInsertId();
                $_SESSION['rules'] = 'user';
                $_SESSION['email'] = $email;

                return "<p>You are registered.</p>";
            }
        }
        return "<p>Error! You are not registered.</p><br><p><a href='/user/registration'>Back</a></p>";
    }

    /** Авторизирует пользователя
     * @return string
     */
    public static function loginUser()
    {
        // если логин и пароль переданны
        if (!empty($_POST['nick']) && !empty($_POST['pass']))
        {
            // забрать их из массива
            $nick = trim(htmlspecialchars($_POST['nick']));
            $pass = trim(htmlspecialchars($_POST['pass']));

            // найти в бд. пользователь может войти как по нику, так и по почте!
            // найдено будет не более одного пользователя, т.к. ник и почта уникальны,
            // а ввод елктронной почты в поле ника несколько раз проверяется
            $user = self::getUser($nick, $nick);

            // если пользователь найден и введенный пароль совпадает с записанным в базе
            if ($user & password_verify($pass, $user['pass']))
            {
                //return debug($user);

                // записать в сессию данные активизированного пользователя
                $_SESSION['nick'] = $user['nick'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['rules'] = $user['rules'];
                $_SESSION['email'] = $user['email'];

                return "<p>Welcome, {$_SESSION['nick']}</p>";
            }
            else
                {
                    return "<p>User not found.</p><br><p><a href='/user/login'>Back</a></p>";
                }
        }
    }

    /** Закрывает сессию и удаляет данные об активизированном пользователе
     * @return string
     */
    public static function exitUser()
    {
        /*unset($_SESSION['nick']);
        unset($_SESSION['rules']);
        unset($_SESSION['id']);
        unset($_SESSION['email']);*/

        // скопированно из рекомендации в мануале к php
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        return "<p>Session finished.</p>";
    }

    /** Возвращает данные профиля пользователя по его id
     * @return array|mixed
     */
    public static function profileUser()
    {
        // медот является публичной оберткой для защищенного модуля getProfile

        // если в сессии есть идентификатор авторизированного пользователя
        if (!empty($_SESSION['id']))
        {
            $id = $_SESSION['id'];
            // вернуть данные его профиля
            return self::getProfile($id);
        }
        return [];
    }

    /** Обноляет измененные данные профиля пользователя
     * @return string
     */
    public static function updateProfile()
    {
        // получить идентификатор пользователя
        $id = $_SESSION['id'];
        //найти профиль пользователя по идентификатору
        $user = self::getProfile($id);
        // если профиль не найден
        if (!$user)
        {
            // создать пустой профиль
            $db = self::connect();
            $smtp = $db->pdo->prepare("INSERT INTO `users`(`id_log`) VALUES (:id)");
            $smtp->bindValue('id', $id);
            if (!$smtp->execute())
            {
                echo "<p>Profile not created<p>";
            }
            $user = self::getProfile($id);
        }

        //debug($user);
        //debug($_POST);

        // для всех пар поле->значение из профиля пользователя
        foreach ($user as $field => $value)
        {
            //echo "$field -> $value";

            // если существует запись в массиве POST с именем поля из профиля
            if (isset($_POST[$field]))
            {
                // получить новое значение из массива POST
                $newvalue = trim(htmlspecialchars($_POST[$field]));
                // если новое значение не пустое и не равно старому
                if (!empty($newvalue) && ($newvalue !== $value))
                {
                    // внести изменение в бд
                    if(!self::updateOne('users', $id, $field, $newvalue))
                    {
                        return "Profile not updated";
                    }
                }
            }
        }

        // получить данные о пользователе по его нику
        $user = self::getUser($_SESSION['nick'], '');

        // получить ник из массива POST
        $nick = trim(htmlspecialchars($_POST['nick']));
        // еще раз проверить, чтобы новый ник не был пустым и не был почтовым адресом (избыточная проверка)
        // если новый ник не совпадает с ником из данных пользователя
        if (!empty($nick) && !strpos($nick, '@') && ($nick !== $user['nick']))
        {
            // выполнить обновление и проверить результат
            if(!self::updateOne('login', $id, 'nick', $nick))
            {
                return "Profile not updated";
            }
            // если все в порядке - записать в сессию новый ник пользователя
            $_SESSION['nick'] = $nick;
        }

        // получить почту из массива POST
        $email = trim(htmlspecialchars($_POST['email']));
        // еще раз проверить, чтобы новая почта не была пустой (избыточная проверка)
        // если новая почта не совпадает с почтой из данных пользователя
        if (!empty($email) && ($email !== $user['email']))
        {
            if(!self::updateOne('login', $id, 'email', $email))
            {
                // выполнить обновление и проверить результат
                return "Profile not updated";
            }
            // если все в порядке - записать в сессию новую почту пользователя
            $_SESSION['email'] = $email;
        }

        // получить пароли из массива POST
        $pass1 = trim(htmlspecialchars($_POST['pass1']));
        $pass2 = trim(htmlspecialchars($_POST['pass2']));
        // если первый пароль не пуст, оба пароля совпадают и первый пароль НЕ совпадает с паролем пользователя
        if (!empty($pass1) && ($pass1 === $pass2) && !password_verify($pass1, $user['pass']))
        {
            // зашифровать новый пароль
            $newpass = password_hash($pass1, PASSWORD_DEFAULT);
            // внести изменения в бд
            if(!self::updateOne('login', $id, 'pass', $newpass))
            {
                return "Password not updated";
            }
        }

        return "Profile updated";
    }

    /** Обновляет картинку пользователя
     * @return bool
     */
    public static function uploadImage()
    {
        //debug($_FILES);

        // если файл загружен без ошибок
        if ($_FILES['file']['error'] == 0)
        {
            // получить массив разрешенных форматов файлов
            $fallow = include(ROOT . '/config/allowed_files.php');
            // получить тип загруженного файла
            $finfo = new \finfo();
            $ftype = $finfo->file($_FILES['file']['tmp_name'], FILEINFO_MIME_TYPE);
            // если тип загруженного файла находится в списке разрешенных
            if (in_array($ftype, $fallow))
            {
                // сформировать новое имя загруженного файла (ник+уникальный код+разрешение)
                $fext = '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $new_file = uniqid($_SESSION['nick']) . $fext;
                //если перемещение загруженного файла прошло успешно
                if (move_uploaded_file($_FILES['file']['tmp_name'], 'views/img/' . $new_file))
                {
                    // получить профиль пользователя по идентификатору
                    $id = $_SESSION['id'];
                    $user = self::getProfile($id);
                    // получить название старого файла картинки
                    $old_file = $user['img'];
                    // если обновление имени файла пройло успешно
                    if (self::updateOne('users', $id, 'img', $new_file))
                    {
                        // удалить старый файл
                        unlink('views/img/' . $old_file);
                        return true;
                    }
                }
                /*return false;*/
            }
            /*return false;*/
        }
        return false;
    }
}