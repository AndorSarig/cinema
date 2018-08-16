<?php
/**
 * Created by PhpStorm.
 * User: andorsarig
 * Date: 16.08.2018
 * Time: 19:19
 */

namespace Controller;


use View\Renderer;
use Model\User\UserActions;

class UserController
{
    public function signup() : void
    {
        $userActions    = new UserActions();
        $error          = $userActions->signup();
        if (!empty($error)) {
            $this->loadSignup($error);
        }
        $redirectTo = isset($_SESSION['redirected-from']) ? $_SESSION['redirected-from'] : '/movies/' ;
        header("Location: $redirectTo");
        unset($_SESSION['redirected-from']);
    }

    public function login() : void
    {
        $userActions            = new UserActions();
        $userId                 = $userActions->login();
        if ($userId < 0) {
            $this->loadLogin('Incorrect email or password!');
            return;
        }
        $_SESSION['user-id']    = $userId;
        $redirectTo = isset($_SESSION['redirected-from']) ? $_SESSION['redirected-from'] : '/movies/' ;
        header("Location: $redirectTo");
        unset($_SESSION['redirected-from']);
    }

    public function logout() : void
    {
        $userActions = new UserActions();
        $userActions->logout();
    }

    public function loadLogin($error = null) : void
    {
        $renderer       = new Renderer();
        $pageToRender   = 'src/View/templates/login.phtml';
        $output         = $renderer->render($pageToRender, ["error" => $error]);
        echo $output;
    }

    public function loadSignup($error = null) : void
    {
        $renderer       = new Renderer();
        $pageToRender   = 'src/View/templates/signup.phtml';
        $output         = $renderer->render($pageToRender, ["error" => $error]);
        echo $output;
    }
}