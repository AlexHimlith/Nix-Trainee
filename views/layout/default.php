<?php
    require_once 'Header.php';
    require_once 'Navigation.php';
    require_once 'Footer.php';

    $path = PROJECT_PATH . '/views/css/style.css';
    //echo $path;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <!--<link rel="stylesheet" href="../css/reset.css">-->
    <link rel="stylesheet" href="<?php echo $path ?>">
</head>
<body>
<?php
/*
    require_once 'functions.php';
    require_once 'Header.php';
    require_once 'Navigation.php';
    require_once 'Footer.php';
    require_once 'Posts.php';

    require_once 'core/Router.php';
    require_once 'controllers/PostsController.php';
    require_once 'controllers/MainController.php';

    //Корень
    define('ROOT', dirname(__DIR__));
    // Файлс с массивом
    define('FILENAME', 'posts.txt');
    // Путь папки проекта, задать '' если проект не лежит в отдельной папке
    define('PROJECT_PATH','/nix_trainee/');

    $content = '';*/
?>

<header>
    <?php
        echo Header::getHeader();
    ?>
</header>

    <?php
        echo Navigation::getMenu();
    ?>

<main>
    <?php
        echo $content;
    ?>
</main>

<footer>
    <?php ;
        echo Footer::getFooter();
    ?>
</footer>

</body>
</html>