<?php

    use views\layout\Header;
    use views\layout\Navigation;
    use views\layout\Footer;

    $path = PROJECT_PATH . '/views/css/style.css';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <!--<link rel="stylesheet" href="../css/reset.css">-->
    <link rel="stylesheet" href="<?php echo $path ?>">
</head>
<body>

<header>
    <?php
        echo \views\layout\Header::getHeader();
    ?>
</header>

    <?php
        echo \views\layout\Navigation::getMenu();
    ?>

<main>
    <?php
        echo $content;
    ?>
</main>

<footer>
    <?php
        echo \views\layout\Footer::getFooter();
    ?>
</footer>

</body>
</html>