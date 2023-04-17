<?php

$host = 'lesson34';
$port = 3305;
$dbname = 'my_db';
$user = 'root';
$pass = 'root';
$charset = 'utf8';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
//    echo "Успешно подключение к БД";
} catch (PDOException $e) {
    echo "Ошибка подключения к БД :" . $e->getMessage() . "<br>";
    die();
}