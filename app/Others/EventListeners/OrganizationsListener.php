<?php

namespace WWCrm\Others\EventListeners;

use WWCrm\Others\Events\Organizations\Create; // Создание
use WWCrm\Others\Events\Organizations\Update; // Обновление

class OrganizationsListener {
    public function create(Create $event) {
        // Код который каждый раз будет срабатывать при создании оргонизации/клиента

        // dump($event->getOrganization()->name);
    }

    public function update(Update $event) {
        // Код который каждый раз будет срабатывать при обновлении оргонизации/клиента
    }
}