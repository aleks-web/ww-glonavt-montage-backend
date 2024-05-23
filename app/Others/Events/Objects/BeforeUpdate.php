<?php

namespace WWCrm\Others\Events\Objects;

use Symfony\Contracts\EventDispatcher\Event;
use WWCrm\Models\Objects;

use WWCrm\Dto\ObjectDto as Dto;

// Событие до обновления объекта
class BeforeUpdate extends Event {
    public const NAME = 'object.beforeupdate';

    protected $obj;
    protected $dto;

    public function __construct(Objects $obj, Dto $dto) {
        $this->obj = $obj;
        $this->dto = $dto;
    }

    /*
        Возвращает обновлённый объект
    */
    public function getObject(): Objects {
        return $this->obj;
    }

    /*
        Возвращает dto
    */
    public function getDto(): Dto {
        return $this->dto;
    }
}