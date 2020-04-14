<?php
include "PdoRepository.php";

session_start();
$pdoRepository = new PdoRepository();
$pdo = $pdoRepository->getPdo();
$sql = "SELECT password FROM user WHERE id = " .  $_SESSION['id'];
$statment = $pdo->prepare($sql);
$statment->execute();
$record = $statment->fetch(PDO::FETCH_ASSOC);

$passVerify = password_verify($_POST['current'], $record['password']);
if($passVerify){
 if($_POST['password'] == $_POST['password_confirmation']){
     $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
     $sql = "UPDATE user SET password ='" . $pass . "' WHERE id =" .  $_SESSION['id'];
     $statment = $pdo->prepare($sql);
     $statment->execute();
     $_SESSION['success_pass'] = 'Yuooo Hoooo';
     header('Location: /profile.php');
     die;
 }
    if($_POST['password'] != $_POST['password_confirmation']){
        $_SESSION['err_confirm_pass'] = 'Password doesn\'t match';
        header('Location: /profile.php');
        die;
    }
}
if(!$passVerify){
    $_SESSION['err_pass_virify'] = 'Password doesn\'t match';
    header('Location: /profile.php');
    die;
}

header('Location: /profile.php');