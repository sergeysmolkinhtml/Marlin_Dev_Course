<?php


namespace App\Services;

use Delight\Auth\Auth;

class AuthService
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }


    public function getLoggedInUserId() : ?int
    {
        return $this->auth->id();
    }


}
