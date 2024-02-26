<?php

namespace WWCrm\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use WWCrm\Models\Clients;

class ClientsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) {
        // $s = $this->WWCurrentUser->isAuterisation();

        // Получаем параметры
        $page = $request->query->get('page');

        if ($page) {
            $users = Clients::paginate(10);
            $users->withPath('/clients');
        }

        return $this->WWCrmService->get('View')->render('clients.twig', [
            'title' => 'Клиенты',
        ]);
    }

}