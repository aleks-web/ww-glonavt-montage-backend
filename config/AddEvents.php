<?php

// Организации/клиенты
use WWCrm\Others\EventListeners\OrganizationsListener;
use WWCrm\Others\Events\Organizations\Create as OrganizationCreate;
use WWCrm\Others\Events\Organizations\Update as OrganizationUpdate;

// Объекты
use WWCrm\Others\EventListeners\ObjectsListener;
use WWCrm\Others\Events\Objects\Create as ObjectCreate;
use WWCrm\Others\Events\Objects\AfterUpdate as AfterObjectUpdate;
use WWCrm\Others\Events\Objects\BeforeUpdate as BeforeObjectUpdate;

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
        $dispatcher->addListener(AfterObjectUpdate::NAME, [new ObjectsListener(), 'afterUpdate']);
        $dispatcher->addListener(BeforeObjectUpdate::NAME, [new ObjectsListener(), 'beforeUpdate']);

        return $dispatcher; // Возвращаем экзэмпляр EventDispatcher
    }
];