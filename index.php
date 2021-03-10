<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <!--<link rel="stylesheet" href="css/reset.css">-->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php

    require_once 'functions.php';
    require_once 'Header.php';
    require_once 'Navigation.php';
    require_once 'Footer.php';
    require_once 'Posts.php';

    //$filename = 'posts.txt';
    define('FILENAME', 'posts.txt');

    /*if (!file_exists(FILENAME))
    {
        $file = fopen(FILENAME, 'w') or die("File Is Not Been Created");
        fclose($file);
    }*/

    $content = '';

    // Примитивный рутер. Пока такой
    if ($_GET['r'] == 'newpost')
    {
        $content = Posts::getFormNewPost();
    }

    if ($_GET['r'] == 'posts')
    {
        $content = Posts::getListPosts();
    }

    if ($_GET['r'] == 'addpost')
    {
        $posts = json_decode(file_get_contents(FILENAME), TRUE);
        $post = Posts::getNewPost();
        $posts[] = $post;
        if(file_put_contents(FILENAME, json_encode($posts)))
        {
            $content = "<p>Your Post Has Been Added</p>
            <a href='posts'>Return</a>";
        }
        else
        {
            $content = "<p>Your Post Has Not Been Added</p>";
        }
        //debug($posts);

    }
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