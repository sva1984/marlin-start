<?php
include "PdoRepository.php";

session_start();



if(empty($_POST['name'])) {
    $_SESSION['name'] = 'ALARM!!! It can not be empty';
    header('Location: /register.php');
    die;
}
if(empty($_POST['email'])) {
    $_SESSION['email'] = 'ALARM!!! It can not be empty';
    header('Location: /register.php');
    die;
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email'] = 'ALARM!!! Wrong email, try again';
    header('Location: /register.php');
    die;
}
$pdoRepository = new PdoRepository();
$pdo = $pdoRepository->getPdo();
$sql = "SELECT email FROM `user` WHERE email = '" . $_POST['email'] . "'";
$statment = $pdo->prepare($sql);
$statment->execute();
$email = $statment->fetch(PDO::FETCH_ASSOC);

if(!empty($email)) {
    $_SESSION['email'] = 'This email already been taken';
    header('Location: /register.php');
    die;
}

if(empty($_POST['password'])) {
    $_SESSION['password'] = 'ALARM!!! It can not be empty';
    header('Location: /register.php');
    die;
}

if(strlen($_POST['password']) < 8) {
    $_SESSION['password'] = 'ALARM!!! Passwor must be greter then 8 digits';
    header('Location: /register.php');
    die;
}

if(empty($_POST['password_confirmation'])) {
    $_SESSION['password_confirmation'] = 'ALARM!!! It can not be empty';
    header('Location: /register.php');
    die;
}
if($_POST['password'] != $_POST['password_confirmation']) {
    $_SESSION['password_confirmation'] = 'ALARM!!! Passwords are different';
    header('Location: /register.php');
    die;
}

$currentDate = time();
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
$sql = "INSERT INTO `user` (`id`, `name`, `email`,`password`, `date`) VALUES (NULL, '" .
    $_POST['name'] . "' , '" . $_POST['email'] . "' , '" . $pass .
    "' , '" . $currentDate . "' )";
$statment = $pdo->prepare($sql);
$statment->execute();

header('Location: /register.php');

