<?php

namespace WWCrm\Others\EventListeners;

use WWCrm\Others\Events\Objects\Create; // Создание
use WWCrm\Others\Events\Objects\Update; // Обновление


use WWCrm\ServiceContainer;


// Моделька логирования объектов
use WWCrm\Models\ObjLogs;

class ObjectsListener {

    protected $container;
    protected $currentUser;

    public function __construct() {
        $this->container = ServiceContainer::getInstance();
        $this->currentUser = $this->container->get('CurrentUser');
    }

    // Создание
    public function create(Create $event) {
        $obj = $event->getObject();

        // Пишем в лог
        ObjLogs::create([
            'object_id' => $obj->id, // Указываем, что лог предназначен для такого-то объекта
            'event_id' => ObjLogs::EVENT_CREATE, // ID события. В данном случае - обновление
            'user_add_id' => $this->currentUser->getId() // ID текущего юзера (кто обновил объект)
        ]);
    }

    // Обновление
    public function update(Update $event) {
        $obj = $event->getObject();

        // Пишем в лог
        ObjLogs::create([
            'object_id' => $obj->id, // Указываем, что лог предназначен для такого-то объекта
            'event_id' => ObjLogs::EVENT_UPDATE, // ID события. В данном случае - обновление
            'user_add_id' => $this->currentUser->getId() // ID текущего юзера (кто обновил объект)
        ]);
    }
}