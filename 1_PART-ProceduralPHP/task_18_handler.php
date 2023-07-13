
<?php
// delete.php

//Проверяем, был ли передан идентификатор картинки в запросе
If(isset($_GET['id'])) {
    $imageId = $_GET['id'];
// Подключаемся к базе данных (замените значения на ваши собственные)
    $pdo = new PDO('mysql:host=marl;dbname=users', 'root', '');
// Получаем полную запись о картинке из базы данных
    $stmt = $pdo->prepare('SELECT * FROM users.images WHERE idimages = :id');
    $stmt->execute(['id' => $imageId]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);


// ПРоверяем наличие картинки
    if($image) {
        // Получаем название картинки
        $filename = $image['path'];
        // Проверяем, существует ли файл в папке "upload"
        if(file_exists('upload')) {
            // Удаляем картинку
            unlink('upload/' . $filename);

        }
        // Удаляем запись о картинке из базы данных
        $delete = $pdo->prepare("DELETE FROM users.images WHERE idimages = :id");
        $delete->execute(['id' => $imageId]);

        echo 'File deleted';
    } else {
        echo 'File not found';
    }












}
?>
