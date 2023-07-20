<?php


namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Intervention\Image\ImageManager;

class UserService
{
    private UserRepository $userRepository;
    private ImageManager $imageManager;

    public function __construct(UserRepository $userRepository,ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
        $this->userRepository = $userRepository;
    }

    public function changePassword(User $user, $newPassword) : void
    {
        $this->userRepository->updatePassword($user, $newPassword);
    }

    public function setStatus(User $user, $status) : void
    {

    }

    public function uploadAvatar(User $user, $avatarFile) : User
    {
        $avatarPath = 'avatars/' . $user->getId() . '.jpg';

        $this->saveAvatarFile($avatarFile, $avatarPath);

        $user->setAvatar($avatarPath);

        $this->userRepository->updateAvatarPath($user->getId(), $avatarPath);

        return $user;
    }

    private function saveAvatarFile($avatarFile, $avatarPath) : void
    {
        $this->imageManager->make($avatarFile['tmp_name'])
            ->fit(200, 200)
            ->save($avatarPath);
    }


}
