<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php $this->getTitle() ?>
    <!--<link rel="stylesheet" href="../css/reset.css">-->
    <link rel="stylesheet" href="/views/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/views/js/forms.js"></script>
</head>
<body>

    <?php echo $this -> getHeader(); ?>

    <?php echo $this -> getMenu(); ?>

<main>
    <?php echo $content; ?>
</main>

    <?php echo $this -> getFooter(); ?>

</body>
</html>