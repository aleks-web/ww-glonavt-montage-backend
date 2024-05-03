<?php

namespace WWCrm\Controllers\Applications;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicationsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('applications.twig', [
            'title' => 'Заявки',
            'paths' => $this->paths,
        ]);
    }

}