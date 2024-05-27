<?php

namespace WWCrm\Others\Events\Organizations;

use Symfony\Contracts\EventDispatcher\Event;
use WWCrm\Models\Organizations;

class Create extends Event {
    public const NAME = 'organization.create';

    protected $org;

    public function __construct(Organizations $org) {
        $this->org = $org;
    }

    /*
        Возвращает созданную организацию
    */
    public function getOrganization(): Organizations {
        return $this->org;
    }
}