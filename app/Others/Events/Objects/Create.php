<?php

namespace WWCrm\Others\Events\Objects;

use Symfony\Contracts\EventDispatcher\Event;
use WWCrm\Models\Objects;

class Create extends Event {
    public const NAME = 'objects.create';

    protected $obj;

    public function __construct(Objects $obj) {
        $this->obj = $obj;
    }

    /*
        Возвращает созданный объект
    */
    public function getObject(): Objects {
        return $this->obj;
    }
}