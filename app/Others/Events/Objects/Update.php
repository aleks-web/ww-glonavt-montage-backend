<?php

namespace WWCrm\Others\Events\Objects;

use Symfony\Contracts\EventDispatcher\Event;
use WWCrm\Models\Objects;

class Update extends Event {
    public const NAME = 'objects.update';

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