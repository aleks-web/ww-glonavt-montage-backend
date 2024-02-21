<?php

namespace WWCrm\Controllers;

use WWCrm\Models\Clients as Client;

class ClientsController extends \WWCrm\Controllers\MainController {

    public function __invoke() {
        // $s = $this->WWCurrentUser->isAuterisation();

        Client::create(
            [
                'name' => 'asdasd',
                'status' => 1,
                'inn' => 'asdasdasd',
                'director_tel' => 'asdasd',
                'director_fio' => 'asdasd',
                'email' => 'asdaasdasd',
                'legal_address' => 'asdasd',
                'actual_address' => 'asdasd',
                'bank_id' => 1,
                'bic' => 'asdasd',
                'checking_bill_num' => 'asdasd',
                'correspondent_bill_num' => 'asdasd',
                'okpo' => '',
                'okato' => ''
            ]
        );

        return $this->WWCrmService->get('View')->render('clients.twig', [
            'title' => 'Клиенты',
        ]);
    }

}