<?php

namespace WWCrm\Controllers;

use WWCrm\Models\Clients as Client;

class ApplicationsController extends \WWCrm\Controllers\MainController {

    public function __invoke() {
        return $this->view->render('applications.twig', [
            'title' => 'Заявки',
        ]);
    }

}