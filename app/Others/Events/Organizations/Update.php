<?php

namespace WWCrm\Others\Events\Organizations;

use Symfony\Contracts\EventDispatcher\Event;
use WWCrm\Models\Organizations;

class Update extends Event {
    public const NAME = 'organization.update';

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