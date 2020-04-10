<?php
include "PdoRepository.php";
session_start();

$pdoRepository = new PdoRepository();
$pdo = $pdoRepository->getPdo();
$sql = "SELECT id, email, password FROM `user` WHERE email = '" . $_POST['email'] . "'";
$statment = $pdo->prepare($sql);
$statment->execute();
$record = $statment->fetch(PDO::FETCH_ASSOC);

if(empty($_POST['email']) || empty($_POST['password'])) {
    $_SESSION['alarm'] = 'Please reenter your data';
    header('Location: /login.php');
    die;
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email'] = 'ALARM!!! Wrong email, try again';
    header('Location: /register.php');
    die;
}

if(empty($record['email'])) {
    $_SESSION['alarm'] = 'Please check your email or password';
    header('Location: /login.php');
    die;
}

$passwordVerify = password_verify($_POST['password'], $record['password']);

if(!$passwordVerify) {
    $_SESSION['alarm'] = 'Please check your email or password2';
    header('Location: /login.php');
//    print_r($_SESSION['alarm']);
    die;
}
if($passwordVerify){
    $_SESSION['id'] = $record['id'];
    $_SESSION['email'] = $record['email'];
    if(isset($_POST['remember']) && $_POST['remember'] == 'on'){
        $ttl = time()+3600*24;
        setcookie('email', $record['email'], $ttl);
        setcookie('password', $record['password'], $ttl);
    }
    if(isset($_POST['remember']) && $_POST['remember'] != 'on'){
        setcookie('email', $record['email'], time()-3600);
        setcookie('password', $record['password'], time()-3600);
    }
}

header('Location: /index.php');

