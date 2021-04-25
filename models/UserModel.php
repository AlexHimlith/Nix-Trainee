<?php


namespace models;


class UserModel extends \core\Model
{
    protected static function getUser($db, $nick, $email)
    {
        $smtp = $db->pdo->prepare("SELECT * FROM `login` WHERE `nick` = :nick OR `mail` = :email");
        $smtp->bindValue('nick', $nick);
        $smtp->bindValue('email', $email);
        $smtp->execute();
        return $smtp->fetch();
    }

    public static function newUser()
    {
        //debug($_POST);
        if (!empty($_POST['nick']) && !empty($_POST['email']) && !empty($_POST['pass1']) && ($_POST['pass1'] === $_POST['pass2']))
        {
            $nick = trim(htmlspecialchars($_POST['nick']));
            $email = trim(htmlspecialchars($_POST['email']));
            $pass1 = trim(htmlspecialchars($_POST['pass1']));

            $db = self::connect();
            $user = self::getUser($db, $nick, $email);

            if ($user)
            {
                return "<p>This nick or e-mail already exists.<p><br><p><a href='/user/registration'>Back</a></p>";
            }
            $pass = password_hash($pass1, PASSWORD_DEFAULT);
            $smtp = $db->pdo->prepare("INSERT INTO `login` (`nick`, `mail`, `pass`) VALUES (:nick, :mail, :pass)");
            $smtp->bindValue('nick', $nick);
            $smtp->bindValue('mail', $email);
            $smtp->bindValue('pass', $pass);
            if ($smtp->execute())
            {
                $_SESSION['nick'] = $nick;
                $_SESSION['id'] = $db->pdo->lastInsertId();
                $_SESSION['rules'] = 'user';
                //setcookie('auth', $_SESSION['nick'], time() + 600);
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

            $db = self::connect();
            $user = self::getUser($db, $nick, $nick);

            if ($user & password_verify($pass, $user['pass']))
            {
                //return debug($user);
                $_SESSION['nick'] = $nick;
                $_SESSION['id'] = $user['id'];
                $_SESSION['rules'] = $user['rules'];

                //setcookie('auth', $_SESSION['nick'], time() + 600);
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
        //setcookie('auth', $_SESSION['nick'], time() - 3600);
        unset($_SESSION['nick']);
        unset($_SESSION['rules']);
        unset($_SESSION['id']);
        return "<p>Session finished.</p>";
    }
}