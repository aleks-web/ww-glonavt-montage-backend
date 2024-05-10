<?php

namespace WWCrm\Others\EventListeners;

use WWCrm\Others\Events\Objects\Create; // Создание
use WWCrm\Others\Events\Objects\Update; // Обновление

class ObjectsListener {
    public function create(Create $event) {
        // Код который каждый раз будет срабатывать при создании объекта

        // dump($event->getOrganization()->name);
    }

    public function update(Update $event) {
        // Код который каждый раз будет срабатывать при обновлении объекта
    }
}