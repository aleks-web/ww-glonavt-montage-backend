<?php

namespace WWCrm\Controllers\Clients;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use WWCrm\Models\Organizations;

class ClientsController extends \WWCrm\Controllers\MainController {

    public function __invoke(Request $request, Response $response) { 

        return $this->WWCrmService->get('View')->render('modules/clients/page.twig', [
            'title' => 'Клиенты',
            'paths' => $this->paths,
            'org_statuses' => Organizations::getArrayStatusesNamed(),
            'query' => $request->query->all()
        ]);
    }

}