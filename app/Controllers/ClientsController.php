<?php

namespace WWCrm\Controllers;

class ClientsController extends \WWCrm\Controllers\MainController {

    public function __invoke() {
        $s = $this->WWCrmService->get('CurrentUser')->isAuterisation();

        dump($s);

        return $this->WWCrmService->get('View')->render('main.twig', [
            'title' => 'Клиенты',
        ]);
    }

}