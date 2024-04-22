<?php

namespace WWCrm\Controllers\Objects;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ObjectsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('modules/objects/page.twig', [
            'title' => 'Объекты',
            'current_user' => $this->WWCurrentUser->getUserObject()
        ]);
    }

}