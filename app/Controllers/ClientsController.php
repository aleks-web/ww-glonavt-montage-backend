<?php

namespace WWCrm\Controllers;

use Symfony\Component\HttpFoundation\Request;
use WWCrm\Models\Clients as Client;

class ClientsController extends \WWCrm\Controllers\MainController {

    public function __invoke() {
        // $s = $this->WWCurrentUser->isAuterisation();

        return $this->WWCrmService->get('View')->render('clients.twig', [
            'title' => 'Клиенты',
        ]);
    }

    public function create(\Symfony\Component\HttpFoundation\Request $request) {

        // Получаем параметры с формы
        $params = $request->request->all();

        var_dump($params);

        // Client::create($params);
    }

    

}