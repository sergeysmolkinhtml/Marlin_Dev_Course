<?php

namespace App\Controllers;

use App\Exceptions\AccountIsBlocked;
use App\Exceptions\NotEnoughMoney;
use App\QueryBuilder;
use Delight\Auth\Auth;
use JetBrains\PhpStorm\NoReturn;
use League\Plates\Engine;
use PDO;
use Tamtamchik\SimpleFlash\Exceptions\FlashTemplateNotFoundException;
use function Tamtamchik\SimpleFlash\flash;

/**
 * @todo Dependency injection
 *
 */
class HomeController
{

    private $auth;
    //вытаскиеваем ответсвеноость с класса
    public function __construct()
    {
        $templates = new Engine();
        $db = new \PDO('mysql:dbname=pack;host=marl;charset=utf8mb4', 'root', '');
        $this->auth = new Auth($db);
    }

     public function index($vars) : void
     {
         try {
             $this->auth->admin()->addRoleForUserById(1, \Delight\Auth\Role::ADMIN);
         }
         catch (\Delight\Auth\UnknownIdException $e) {
             die('Unknown user ID');
         }
        $templates = new Engine('../app/Views');

         echo $templates->render('homepage', ['name' => 'Jonathan']);
    }

    public function about($vars) : void
    {
        try {
            $this->withdraw(15);
        } catch (\Exception $exception){
            flash()->error($exception->getMessage());
        } catch (AccountIsBlocked $exception){

        }

        $templates = new Engine('../app/Views');

        echo $templates->render('about', ['name' => 'Jonathan about']);
    }

    /**
     * @param int $amount
     * @return void
     * @throws NotEnoughMoney
     */
    public function withdraw(int $amount = 1) : void
    {
        $total = 10;

        if($amount > $total) {
            throw new NotEnoughMoney('Недостаточно средств');
        }
    }

    public function signUp() : void
    {

        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function emailVerification()
    {
        try {
            $this->auth->confirmEmail('rtn2KMxQiDXk58DQ', '-WwnJxL1MjoqzqTm');

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

}


