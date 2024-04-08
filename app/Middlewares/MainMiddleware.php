<?php

namespace WWCrm\Middlewares;

use Buki\Router\Http\Middleware;
use Symfony\Component\HttpFoundation\Request;

class MainMiddleware extends Middleware {

    public function handle(Request $request) {
        $WWCrmContainer = \WWCrm\ServiceContainer::getInstance();

        if (!$WWCrmContainer->get('CurrentUser')->isAuterisation()) { // Если нет авторизации, перенаправляем на страницу авторизации
            header('Location: /auth'); // Перенаправляем на страницу авторизации

            return false;
        }

        return true;
    }
}