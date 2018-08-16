<?php

namespace Model\User;


use Model\Repositories\UserRepository;

class UserActions
{
    public function login() : int
    {
        $userRepo = new UserRepository();
        return $userRepo->checkLoginData();
    }

    public function signup() : string
    {
        $validate = new Validator();
        $error = $validate->validateSignupEmail($_POST['email'], $_POST['email-again']);
        $error .= $validate->validateSignupPassword($_POST['passwd'], $_POST['passwd-again']);
        if (!empty($error)) {
            return $error;
        }
        $userRepo = new UserRepository();
        $userRepo->uploadUserData();
        return '';
    }

    public function logout() : void
    {
        unset($_SESSION['user-id']);
        header('Location: /movies/');
    }
}