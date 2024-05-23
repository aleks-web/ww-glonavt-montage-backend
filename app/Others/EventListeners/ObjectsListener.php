<?php

namespace WWCrm\Others\EventListeners;

use WWCrm\Others\Events\Objects\Create; // Создание
use WWCrm\Others\Events\Objects\AfterUpdate; // После обновления
use WWCrm\Others\Events\Objects\BeforeUpdate; // До обновления


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

    // Обработчик события до обновления объекта
    public function beforeUpdate(BeforeUpdate $event) {
        $obj = $event->getObject();
        $dto = $event->getDto();

        mail('dok.go@yandex.ru', 'My Subject', $dto->getGnum() . '<- Новое : Старое ->' . $obj->gnum);

        if (!empty($obj->gnum) && !empty($dto->getGnum())) {
            if (trim($obj->gnum) != trim($dto->getGnum())) { // Если старое значение из $obj не равно новому, то пишем в лог, что гос.номер сменился
                // Пишем в лог
                ObjLogs::create([
                    'object_id' => $obj->id, // Указываем, что лог предназначен для такого-то объекта
                    'event_id' => ObjLogs::EVENT_GNUM, // ID события. В данном случае - смена гос.номера
                    'user_add_id' => $this->currentUser->getId() // ID текущего юзера (кто обновил объект)
                ]);
            }
        }
    }

    // Обработчик события после обновления
    public function afterUpdate(AfterUpdate $event) {
        $obj = $event->getObject();
        // $dto = $event->getDto();

        // Пишем в лог
        ObjLogs::create([
            'object_id' => $obj->id, // Указываем, что лог предназначен для такого-то объекта
            'event_id' => ObjLogs::EVENT_UPDATE, // ID события. В данном случае - обновление
            'user_add_id' => $this->currentUser->getId() // ID текущего юзера (кто обновил объект)
        ]);
    }
}