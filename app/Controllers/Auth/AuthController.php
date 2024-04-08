<?php

namespace WWCrm\Controllers\Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {

        /*
            Если пользователь авторизован, то редиректим на главную
        */
        if ($this->WWCurrentUser->isAuterisation()) {
            header("Location: /");
            exit();
        } else { // Иначе показываем форму авторизации
            return $this->view->render('auth/sign-in.twig', [
                'title' => 'Авторизация'
            ]);
        }
    }

}