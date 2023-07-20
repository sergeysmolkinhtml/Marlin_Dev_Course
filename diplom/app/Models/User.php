<?php

namespace App\Models;

final class User extends BaseModel
{

    private Int $id;
    private String $name;
    private String $email;
    private String $avatar;

    private const USERS_TABLE = 'users';

    public function __construct($id, $name, $email)
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }




}