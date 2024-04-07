<?php

namespace WWCrm\Controllers\Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('auth/sign-in.twig', [
            'title' => 'Авторизация',
            'user_id' => password_hash('admin', PASSWORD_DEFAULT)
        ]);
    }

}