<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\Redirect;
use App\Services\Session;
use App\Services\UserService;
use Delight\Auth\AuthError;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\Role;
use League\Plates\Engine;

class UsersController
{

    private Engine $templateEngine;
    private AuthService $authService;
    private UserRepository $userRepository;
    private UserService $userService;

    public function __construct(
        Engine $templateEngine,
        AuthService $authService,
        UserService $userService,
        UserRepository $userRepository,
    ) {
         $this->templateEngine = $templateEngine;
         $this->authService = $authService;
         $this->userService = $userService;
         $this->userRepository = $userRepository;
     }


    public function index() : void
    {

        $users = $this->userRepository->getAll();
        $this->authService->assignAdminToUserById($this->authService->getLoggedInUserId());

        $loggedInUser = $this->authService->getLoggedInUser();

        echo $this->templateEngine->render('users', [
            'users' => $users,
            'loggedInUser' => $loggedInUser,
        ]);
    }

    public function edit($id) : void
    {
        $user = $this->userRepository->getById($id);

        echo $this->templateEngine->render('edit', ['user' => $user]);
    }

    public function update($id) : void
    {
        $user = $this->userRepository->getById($id);
        $loggedInUserId = $this->authService->getLoggedInUserId();

        if ($loggedInUserId !== $id &&
            ! $this->authService->getLoggedInUser()->hasRole(Role::ADMIN)
            && $user['role'] !== 'admin'
        ) {
            Session::flash('error-modifying','Cant modify others profiles');
            Redirect::to('edit-page/id=' . $id);
        }

        $this->userRepository->update($id, data: $_POST);

        Session::flash('success-update','Successfully updated profile');
        Redirect::to('users');
    }

    public function securitySettings($id) : void
    {
        $user = $this->userRepository->getById($id);
        echo $this->templateEngine->render('security',['user' => $user]);
    }

    public function changeAuthData($id) : void
    {

        $loggedInUserId = $this->authService->getLoggedInUserId();
        $user = $this->userRepository->getById($id);

        if ($loggedInUserId !== $id &&
            ! $this->authService->getLoggedInUser()->hasRole(Role::ADMIN)
            && $user['role'] !== 'admin')
        {
            Session::flash('error-modify','Cant modify others profiles');
            Redirect::to('users.php');
        }

        $this->userRepository->updatePassword($id, $_POST);
        $this->userRepository->updateEmail($id, $_POST['email']);

        Session::flash('success-security','Successfully updated auth');

        Redirect::to('/users');


    }

    public function status($id) : void
    {
        $user = $this->userRepository->getById($id);

        echo $this->templateEngine->render('status', ['user' => $user]);
    }

    public function changeStatus($id) : void
    {

        $loggedInUserId = $this->authService->getLoggedInUserId();
        $user = $this->userRepository->getById($id);

        if ($loggedInUserId !== $id &&
            ! $this->authService->getLoggedInUser()->hasRole(Role::ADMIN)
            && $user['role'] !== 'admin')
        {
            Session::flash('error-status','Cant modify others profiles');
            Redirect::to('users.php');
        }

        $this->userRepository->updateStatus($id, $_POST['status']);
        var_dump('success');
        Redirect::to('/');
    }

    public function uploadAvatarform($id) : void
    {
        $user = $this->userRepository->getById($id);

        echo $this->templateEngine->render('media', ['user' => $user]);
    }

    public function uploadAvatar($id) : void
    {

        $loggedInUserId = $this->authService->getLoggedInUserId();
        $user = $this->userRepository->getById($id);

        if ($loggedInUserId !== $id &&
            ! $this->authService->getLoggedInUser()->hasRole(Role::ADMIN)
            && $user['role'] !== 'admin')
        {
            Session::flash('error','Cant modify others profiles');
            Redirect::to('users');
        }

        $photoFile = $_FILES['avatar'];

        $filename = $this->userService->uploadAvatar($photoFile);

        if ($filename) {
            $this->userRepository->update($id, ['avatar' => $filename]);
        }

        Session::flash('success-image','Successfully updated avatar');
        Redirect::to('/');

    }

    public function delete($id) : void
    {
        $this->userRepository->delete($id);
        Redirect::to('users');
    }




}