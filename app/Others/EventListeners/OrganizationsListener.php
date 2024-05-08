<?php

namespace WWCrm\Others\EventListeners;

use WWCrm\Others\Events\Organizations\Create;

class OrganizationsListener {
    public function create(Create $event) {
        // Код который каждый раз будет срабатывать при создании оргонизации/клиента

        // dump($event->getOrganization()->name);
    }
}