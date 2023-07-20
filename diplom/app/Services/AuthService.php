<?php


namespace App\Services;

use Delight\Auth\Auth;
use Delight\Auth\Role;
use Delight\Auth\UnknownIdException;

class AuthService
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getLoggedInUser() : Auth
    {
        return $this->auth;
    }

    public function getLoggedInUserId() : int
    {
        return $this->auth->id();
    }

    /**
     * @throws UnknownIdException
     */
    public function assignAdminToUserById($id) : void
    {
        $this->auth->admin()->addRoleForUserById($id,Role::ADMIN);
    }

}
