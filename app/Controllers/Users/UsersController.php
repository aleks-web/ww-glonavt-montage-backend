<?php

namespace WWCrm\Controllers\Users;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('modules/users/page.twig', [
            'title' => 'Сотрудники',
            'paths' => $this->paths,
            'query' => $request->query->all()
        ]);
    }

}