<?php
include "PdoRepository.php";

session_start();

if(empty($_POST['text'])){
    $_SESSION['text'] = 'Yuooo Hoooo';
    header('Location: /index.php');
    die;
}

$currentDate = time();
$sql = "INSERT INTO `comment` (`id`, `id_user`, `comment`, `date`) VALUES (NULL, '" .
    $_SESSION['id'] . "' , '" . $_POST['text'] . "' , '" . $currentDate . "' )";
$pdoRepository = new PdoRepository;
$pdo = $pdoRepository->getPdo();
$statment = $pdo->prepare($sql);
$statment->execute();

header('Location: /index.php');
$_SESSION['success'] = 'Yuooo Hoooo';