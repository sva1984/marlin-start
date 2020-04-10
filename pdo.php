<?php
$driver = 'mysql'; // тип базы данных, с которой мы будем работать

$host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального

$db_name = 'start'; // имя базы данных

$db_user = 'root'; // имя пользователя для базы данных

$db_password = ''; // пароль пользователя

$charset = 'utf8'; // кодировка по умолчанию

$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
// массив с дополнительными настройками подключения. В данном примере мы установили отображение ошибок, связанных с базой данных, в виде исключений
$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
$pdo = new PDO($dsn, $db_user, $db_password, $options);

$sql = "INSERT INTO `comment` (`id`, `name`, `comment`) VALUES (NULL, 'Leo', 'Com3')";
$statment = $pdo->prepare($sql);
$statment->execute();

$sql = "SELECT * FROM comment";
$statment = $pdo->prepare($sql);
$statment->execute();

$rezult = $statment->fetchAll(PDO::FETCH_ASSOC);

print_r($rezult);