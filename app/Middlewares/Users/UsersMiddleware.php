<?php

namespace WWCrm\Middlewares\Users;

use Buki\Router\Http\Middleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersMiddleware extends Middleware {

    public function handle(Request $request, Response $response) {
        $WWCrmContainer = \WWCrm\ServiceContainer::getInstance();

        return true;
    }
}