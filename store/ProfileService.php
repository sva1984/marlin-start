<?php
include "PdoRepository.php";

session_start();
if(!empty($_FILES['image']['tmp_name'])){
    $_SESSION['img_url'] = uniqid() . '.jpg';
    move_uploaded_file($_FILES['image']['tmp_name'], '../img/' . $_SESSION['img_url']);
}
if($_SESSION['email'] != $_POST['email']){
    $pdoRepository = new PdoRepository();
    $pdo = $pdoRepository->getPdo();
    $sql = "SELECT email FROM `user` WHERE email = '" . $_POST['email'] . "'";
    $statment = $pdo->prepare($sql);
    $statment->execute();
    $email = $statment->fetch(PDO::FETCH_ASSOC);

    if(!empty($email)) {
        $_SESSION['err_email'] = 'This email already been taken';
        header('Location: /profile.php');
        die;
    }
}
$pdoRepository = new PdoRepository();
$pdo = $pdoRepository->getPdo();
$sql = "UPDATE user SET name ='" . $_POST['name'] . "', email = '" . $_POST['email'] .
       "', img_url = '" . $_SESSION['img_url'] ."' WHERE id =" .  $_SESSION['id'];
$statment = $pdo->prepare($sql);
$statment->execute();
$_SESSION['name'] = $_POST['name'];
$_SESSION['email'] = $_POST['email'];

header('Location: /profile.php');