<?php
session_start();

require 'functions.php';
$pdo = new PDO('mysql:host=marl;dbname=module','root', '');

if($_POST) {

    $id = $_SESSION['user']['id'];

    $statement = $pdo->prepare(
        "UPDATE module.users SET name = :name, job = :job, phone=:phone, address=:address WHERE id = $id"
    );

    $statement->execute($_POST);

    $updUser = $statement->fetch(PDO::FETCH_ASSOC);

    header("Location: http://marl/Module/Верстка%20проекта/edit.php?id=" . $id);


}
