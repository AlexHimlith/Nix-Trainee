<?php


namespace models;


class UserModel extends \core\Model
{
    protected static function getUser($nick, $email)
    {
        $db = self::connect();
        $smtp = $db->pdo->prepare("SELECT * FROM `login` WHERE `nick` = :nick OR `email` = :email");
        $smtp->bindValue('nick', $nick);
        $smtp->bindValue('email', $email);
        $smtp->execute();
        return $smtp->fetch();
    }

    protected static function getProfile($id)
    {
        $db = self::connect();
        //$query = "SELECT `users`.*, `login`.`nick`,`mail` FROM `users` LEFT JOIN `login` ON (`users`.`id_log`=`login`.`id`) WHERE `login`.`id` = :idlog";
        $query = "SELECT * FROM `users` WHERE `id_log` = $id";
        $user = $db->pdo->prepare($query);
        //$smtp = $db->pdo->query($query);
        //$smtp->bindValue('idlog', $_SESSION['id']);
        $user->execute();
        return $user->fetch();
    }

    public static function newUser()
    {
        //debug($_POST);
        if (!empty($_POST['nick']) && !empty($_POST['email']) && !empty($_POST['pass1']) && ($_POST['pass1'] === $_POST['pass2']))
        {
            $nick = trim(htmlspecialchars($_POST['nick']));
            $email = trim(htmlspecialchars($_POST['email']));
            $pass1 = trim(htmlspecialchars($_POST['pass1']));

            $user = self::getUser($nick, $email);

            if ($user)
            {
                return "<p>This nick or e-mail already exists.<p><br><p><a href='/user/registration'>Back</a></p>";
            }
            $pass = password_hash($pass1, PASSWORD_DEFAULT);

            $db = self::connect();
            $smtp = $db->pdo->prepare("INSERT INTO `login` (`nick`, `email`, `pass`) VALUES (:nick, :mail, :pass)");
            $smtp->bindValue('nick', $nick);
            $smtp->bindValue('mail', $email);
            $smtp->bindValue('pass', $pass);
            if ($smtp->execute())
            {
                $_SESSION['nick'] = $nick;
                $_SESSION['id'] = $db->pdo->lastInsertId();
                $_SESSION['rules'] = 'user';
                $_SESSION['email'] = $email;

                return "<p>You are registered.</p>";
            }
        }
        return "<p>Error! You are not registered.</p><br><p><a href='/user/registration'>Back</a></p>";
    }

    public static function loginUser()
    {
        if (!empty($_POST['nick']) && !empty($_POST['pass']))
        {
            $nick = trim(htmlspecialchars($_POST['nick']));
            $pass = trim(htmlspecialchars($_POST['pass']));

            //$db = self::connect();
            $user = self::getUser($nick, $nick);

            if ($user & password_verify($pass, $user['pass']))
            {
                //return debug($user);
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

    public static function exitUser()
    {
        /*unset($_SESSION['nick']);
        unset($_SESSION['rules']);
        unset($_SESSION['id']);
        unset($_SESSION['email']);*/

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

    public static function profileUser()
    {
        if (!empty($_SESSION['id']))
        {
            $id = $_SESSION['id'];
            return self::getProfile($id);
        }
        return [];
    }

    public static function updateProfile()
    {
        //$db = self::connect();
        $id = $_SESSION['id'];
        $user = self::getProfile($id);
        if (!$user)
        {
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

        foreach ($user as $field => $value)
        {
            //echo "$field -> $value";
            if (isset($_POST[$field]))
            {
                $newvalue = trim(htmlspecialchars($_POST[$field]));
                if (!empty($newvalue) && ($newvalue !== $value))
                {
                    if(!self::updateOne('users', $id, $field, $newvalue))
                    {
                        return "Profile not updated";
                    }
                }
            }
        }

        $user = self::getUser($_SESSION['nick'], '');

        $nick = trim(htmlspecialchars($_POST['nick']));
        if ($nick !== $user['nick'])
        {
            if(!self::updateOne('login', $id, 'nick', $nick))
            {
                return "Profile not updated";
            }
            $_SESSION['nick'] = $nick;
        }

        $email = trim(htmlspecialchars($_POST['email']));
        if ($email !== $user['email'])
        {
            if(!self::updateOne('login', $id, 'email', $email))
            {
                return "Profile not updated";
            }
            $_SESSION['email'] = $email;
        }

        $pass1 = trim(htmlspecialchars($_POST['pass1']));
        $pass2 = trim(htmlspecialchars($_POST['pass2']));
        if (!empty($pass1) && ($pass1 == $pass2) && !password_verify($pass1, $user['pass']))
        {
            $newpass = password_hash($pass1, PASSWORD_DEFAULT);
            if(!self::updateOne('login', $id, 'pass', $newpass))
            {
                return "Password not updated";
            }
        }

        return "Profile updated";
    }

    public static function uploadImage()
    {
        debug($_FILES);

        if ($_FILES['file']['error'] == 0)
        {
            $fallow = include(ROOT . '/config/allowed_files.php');
            //$finfo = finfo_open(FILEINFO_MIME_TYPE);
            $finfo = new \finfo();
            //debug(finfo_file($finfo,$_FILES['file']['tmp_name']));
            $ftype = $finfo->file($_FILES['file']['tmp_name'], FILEINFO_MIME_TYPE);
            if (in_array($ftype, $fallow))
            {
                $fext = '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $new_file = uniqid($_SESSION['nick']) . $fext;
                if (move_uploaded_file($_FILES['file']['tmp_name'], 'views/img/' . $new_file))
                {
                    $id = $_SESSION['id'];
                    $user = self::getProfile($id);
                    $old_file = $user['img'];
                    if (self::updateOne('users', $id, 'img', $new_file))
                    {
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