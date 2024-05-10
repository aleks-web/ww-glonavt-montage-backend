<?php

// Организации/клиенты
use WWCrm\Others\EventListeners\OrganizationsListener;
use WWCrm\Others\Events\Organizations\Create as OrganizationCreate;
use WWCrm\Others\Events\Organizations\Update as OrganizationUpdate;

// Объекты
use WWCrm\Others\EventListeners\ObjectsListener;
use WWCrm\Others\Events\Objects\Create as ObjectCreate;
use WWCrm\Others\Events\Objects\Update as ObjectUpdate;

/*
    EventDispatcher
*/
return [
    'EventDispatcher' => function() {
        $dispatcher =  new \Symfony\Component\EventDispatcher\EventDispatcher(); // Создаем экземпляр EventDispatcher

        // Добавляем слушателей для организации
        $dispatcher->addListener(OrganizationCreate::NAME, [new OrganizationsListener(), 'create']);
        $dispatcher->addListener(OrganizationUpdate::NAME, [new OrganizationsListener(), 'update']);

        // Добавляем слушателей для объектов
        $dispatcher->addListener(ObjectCreate::NAME, [new ObjectsListener(), 'create']);
        $dispatcher->addListener(ObjectUpdate::NAME, [new ObjectsListener(), 'update']);

        return $dispatcher; // Возвращаем экзэмпляр EventDispatcher
    }
];