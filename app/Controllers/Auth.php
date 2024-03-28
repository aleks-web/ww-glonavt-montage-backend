<?php

namespace WWCrm\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('auth.twig', [
            'title' => 'Авторизация',
        ]);
    }

}