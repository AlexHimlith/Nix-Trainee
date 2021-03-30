<?php
    $dsn = 'mysql:host=localhost; dbname=nixtrainee; charset=utf8';
    $user = 'root';
    $pass = '';
    $opt =
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

