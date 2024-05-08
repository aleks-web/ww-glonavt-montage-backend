<?php

use WWCrm\Others\Events\Organizations\Create as OrganizationCreate;
use WWCrm\Others\EventListeners\OrganizationsListener;

/*
    EventDispatcher
*/
return [
    'EventDispatcher' => function() {
        $dispatcher =  new \Symfony\Component\EventDispatcher\EventDispatcher();
        $dispatcher->addListener(OrganizationCreate::NAME, [new OrganizationsListener(), 'create']);

        return $dispatcher;
    }
];