<?php


if (isset($_FILES['image'])) {
    $uniqueName = uniqid();
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = $uniqueName . '.' . $extension;

    $uploadPath = 'upload/' . $filename;

    move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);
    $pdo = new PDO('mysql:host=marl;dbname=users', 'root', '');
    $stmt = $pdo->prepare('INSERT INTO users.images (path) VALUES (:filename)');
    $stmt->execute(['filename' => $filename]);

    echo "File uploaded";

    header('http://marl/task_17.php');

}


