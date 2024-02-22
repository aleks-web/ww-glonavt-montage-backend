<?php

namespace WWCrm\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use WWCrm\Models\Clients as Client;

class ClientsController extends \WWCrm\Controllers\MainController {

    public function __invoke() {
        // $s = $this->WWCurrentUser->isAuterisation();

        return $this->WWCrmService->get('View')->render('clients.twig', [
            'title' => 'Клиенты',
        ]);
    }

    public function create(Request $request, Response $response) {

        // Получаем параметры с формы
        $params = $request->request->all();

        $client = Client::create($params);

        $response_array['db_fields'] = Client::find($client->id);
        $response_array['status'] = 'succsess';
        $response_array['message'] = 'Клиент создан';

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array));

        return $response;
    }

    

}