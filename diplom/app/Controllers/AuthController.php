<?php

namespace App\Controllers;

use App\Services\Redirect;
use App\Services\Session;
use Delight\Auth\Auth;
use League\Plates\Engine;


class AuthController
{
    private Auth $auth;
    private Engine $template;

    public function __construct(Auth $auth, Engine $template)
    {
        $this->template = $template;
        $this->auth = $auth;
    }

    public function registerForm() : void
    {
        echo $this->template->render('page_register');
    }

    public function registerProcess() : void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($_POST) {

            try {
                $userId = $this->auth->register($email, $password, $email . 'user', function ($selector, $token) {
                    echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                    echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                    echo '  For SMS, consider using a third-party service and a compatible SDK';
                });

                echo 'We have signed up a new user with the ID ' . $userId;
            } catch (\Delight\Auth\InvalidEmailException $e) {
                die('Invalid email address');
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                die('Invalid password');
            } catch (\Delight\Auth\UserAlreadyExistsException $e) {
                die('User already exists');
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                die('Too many requests');
            }
        }
        Session::flash('success-register','Successfully registered!!!');
        Redirect::to('login-page');

    }

    public function changePassword() : void
    {
        if ($_POST) {
            try {
                $this->auth->changePassword($_POST['oldPassword'], $_POST['newPassword']);

                echo 'Password has been changed';
            } catch (\Delight\Auth\NotLoggedInException $e) {
                die('Not logged in');
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                die('Invalid password(s)');
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                die('Too many requests');
            }
        }
    }

    public function loginForm() : void
    {
        echo $this->template->render('page_login');
    }

    public function loginProcess() : void
    {

        if ($_POST) {

            try {
                $this->auth->login($_POST['email'], $_POST['password']);

                echo 'User is logged in';
            } catch (\Delight\Auth\InvalidEmailException $e) {
                die('Wrong email address');
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                die('Wrong password');
            } catch (\Delight\Auth\EmailNotVerifiedException $e) {
                die('Email not verified');
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                die('Too many requests');

            }
        }

        Redirect::to('/users');
    }

    public function logout(): void
    {
        $this->auth->logOut();
    }

    public function verifyEmail() : void
    {
        try {
            $this->auth->confirmEmail('ocfIdEHrw-293aRn', "$2y$10$9J28CGuu/p0oTda8xoFoZulhtWZx26trTdz3OpSg2IhovkVLzc6YK");

            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function assignRoleById($userId)
    {
        try {
            $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
        } catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown user ID');
        }
    }

    public function isLoggedIn() : bool
    {
        return $this->auth->isLoggedIn();
    }

    public function isAdmin($user) : bool
    {
        return $user['role'] === 'admin';
    }

}
