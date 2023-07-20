<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\Redirect;
use App\Services\Session;
use App\Services\UserService;
use DI\Attribute\Inject;
use League\Plates\Engine;

class UsersController
{
    #[Inject]
    private Engine $templateEngine;
    #[Inject]
    private AuthService $authService;
    #[Inject]
    private UserRepository $userRepository;
    #[Inject]
    private UserService $userService;

    public function __construct(
        Engine $templateEngine,
        AuthService $authService,
        UserRepository $userRepository,
        UserService $userService,
    ) {
         $this->templateEngine = $templateEngine;
         $this->authService = $authService;
         $this->userRepository = $userRepository;
         $this->userService = $userService;
     }


    public function index() : void
    {
        $users = $this->userRepository->getAll();

        //$loggedInUserId = $this->authService->getLoggedInUserId();

        $this->templateEngine->render('users', [
            'users' => $users,
            //'loggedInUserId' => $loggedInUserId,
        ]);
    }

    public function update($id) : void
    {
        $loggedInUserId = $this->authService->getLoggedInUserId();

        if ($loggedInUserId !== $id) {
            Session::flash('error','Cant modify others profiles');
            Redirect::to('users.php');
        }

        $name = $_POST['name'];
        $email = $_POST['email'];

        $user = $this->userRepository->getById($id);

        $user->setName($name);
        $user->setEmail($email);

        $this->userRepository->update($user);

        Session::flash('success','Successfully updated profile');
        Redirect::to('update');
    }

    public function changePassword($id) : void
    {
        $loggedInUserId = $this->authService->getLoggedInUserId();

        if ($loggedInUserId !== $id) {
            Session::flash('error','Cant modify others profiles');
            Redirect::to('users.php');
        }

        $newPassword = $_POST['new_password'];

        $user = $this->userRepository->getById($id);


        $this->userService->changePassword($user, $newPassword);

        Session::flash('success','Successfully updated password');
        Redirect::to('/change-password');

    }

    public function uploadAvatar($id) : void
    {

        $loggedInUserId = $this->authService->getLoggedInUserId();

        if ($loggedInUserId !== $id) {
            Session::flash('error','Cant modify others profiles');
            Redirect::to('users.php');
        }
        $avatarFile = $_FILES['avatar'];

        $user = $this->userRepository->getById($id);

        $this->userService->uploadAvatar($user, $avatarFile);

        Session::flash('success','Successfully updated avatar');
        Redirect::to('/');

    }




}