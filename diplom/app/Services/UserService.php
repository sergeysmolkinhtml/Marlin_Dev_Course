<?php

namespace App\Services;



final class UserService
{

    public function uploadAvatar($avatarFile) : string
    {

        $filename = uniqid() . '.' . pathinfo($avatarFile['name'], PATHINFO_EXTENSION);

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $photoExtension = strtolower(pathinfo($avatarFile['name'], PATHINFO_EXTENSION));
        if (!in_array($photoExtension, $allowedExtensions)) {
            return false;
        }

        move_uploaded_file($avatarFile['tmp_name'], 'avatars' );

        return $filename;


    }



}
