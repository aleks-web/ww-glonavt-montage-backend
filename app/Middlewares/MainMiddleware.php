<?php

namespace WWCrm\Middlewares;

use Buki\Router\Http\Middleware;
use Symfony\Component\HttpFoundation\Request;

class MainMiddleware extends Middleware {

    public function handle(Request $request) {
        $WWCrmContainer = \WWCrm\ServiceContainer::getInstance();

        // Разовторизация по timestamp из куков
        if ($request->cookies->get('is_remember') == 0) {
            $sign_in_timestamp = $request->cookies->get('sign_in_timestamp');
            $sign_in_timestamp_next = $sign_in_timestamp + 86400;
            $now_timestamp = time();

            if ($now_timestamp > $sign_in_timestamp_next) {
                $WWCrmContainer->get('CurrentUser')->logout();
            }
        }

        // Проверка авторизован ли пользователь
        if (!$WWCrmContainer->get('CurrentUser')->isAuterisation()) { // Если нет авторизации, перенаправляем на страницу авторизации
            header('Location: /auth'); // Перенаправляем на страницу авторизации

            return false;
        }

        return true;
    }
}