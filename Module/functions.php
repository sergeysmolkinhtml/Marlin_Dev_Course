<?php

function getUserByEmail(String $email) : Bool | Array
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $statement = $pdo->prepare('SELECT * FROM module.users WHERE email = :email');
    $statement->execute(['email' => $email]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getUserById($id)
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $statement = $pdo->prepare('SELECT * FROM module.users WHERE id = :id');
    $statement->execute(['id' => $id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function setFlashMessage(String $name, String $message) : Void
{
    $_SESSION[$name] = $message;
}

function redirect(String $path) : Void
{
    header("Location: http://marl/Module/Верстка%20проекта/{$path}");
    exit();
}

function createUser(String $email, String $password) : Bool | String
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $sql = "INSERT INTO module.users (email, password) VALUES (:email, :password)";
    $statementAdder = $pdo->prepare($sql);

    $statementAdder->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

    $newUser = $statementAdder->fetch(PDO::FETCH_ASSOC);

    return $pdo->lastInsertId();
}

function editUserInfo($username,$job,$phone,$address,$userId) : Void
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $sql = "INSERT INTO module.user_info (name,job,phone,address,user_id) VALUES (:name,:job,:phone,:address,:user_id)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'name' => $username,
        'job' => $job,
        'phone' => $phone,
        'address' => $address,
        'user_id' => $userId,
    ]);
}

function setStatus($status, $userId) : Void
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $sql = "UPDATE module.users SET status = :status WHERE id = $userId";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':status' => $status,
    ]);

}

function uploadAvatar(Array $image, $userId) : bool
{
    $uniqueName = uniqid();
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = $uniqueName . '.' . $extension;

    $uploadPath = 'avatars/' . $filename;

    move_uploaded_file($image['tmp_name'], $uploadPath);
    $pdo = new PDO('mysql:host=marl;dbname=users', 'root', '');
    $stmt = $pdo->prepare("UPDATE module.users SET avatar = :avatar WHERE id=$userId");
    $stmt->execute(['avatar' => $filename]);
    $img = $stmt->fetch(PDO::FETCH_ASSOC);
    return $img;
}

function addSocialLinks($telegram, $instagram, $vk,$userId) : Void
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $sql = "INSERT INTO module.user_socials(vk,telegram,instagram,user_id) VALUES (:vk,:telegram,:instagram,:user_id)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'vk' => $vk,
        'telegram' => $telegram,
        'instagram' => $instagram,
        'user_id' => $userId,
    ]);
}

function displayFlashMessage(String $name) : Void
{
    if(isset($_SESSION[$name])) {
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
        unset($_SESSION[$name]);
    }
}

function getAllUsers() : Array | Bool
{
    $pdo = new PDO('mysql:host=marl;dbname=module', 'root', '');
    $stmt = $pdo->prepare('SELECT * FROM module.users');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function isNotLoggedIn() : Bool
{
    return !isLoggedIn();
}

function isLoggedIn() : Bool
{
    if(isset($_SESSION['user'])) {
        return true;
    }
    return false;
}

function isAdmin($user) : Bool
{
    return $user['role'] == 'admin';
}

function getCurrentUser()
{
    if(isLoggedIn()) {
        return $_SESSION['user'];
    }
   return false;
}

function isEqual($user, $currentUser) : Bool
{
    if($user['id'] == $currentUser['id']){
         return true;
    }
    return false;
}

function createNewUser(Array $data) : Bool
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $sql = "INSERT INTO module.users (name, job, phone, address, avatar,email,password, status, vk, telegram, instagram)
                              VALUES (:name,:job,:phone,:address,:avatar,:email,:password,:status,:vk,:telegram,:instagram)";
    $statementAdder = $pdo->prepare($sql);
    $user = $statementAdder->fetch(PDO::FETCH_ASSOC);
    $user = $statementAdder->execute($data);
    return $user;
}

