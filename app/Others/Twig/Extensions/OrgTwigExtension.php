<?php

namespace WWCrm\Others\Twig\Extensions;

/* 
    ComponentSelectBuilder - Билдер компонента select
    Формирует массив с данными, который нужно прокинуть
    Либо формирует отрендеренный select
*/
use WWCrm\Services\ComponentSelectBuilder;

use WWCrm\Models\Organizations;

class OrgTwigExtension extends \Twig\Extension\AbstractExtension {

    public function __construct() {
        $this->WWCrmService = \WWCrm\ServiceContainer::getInstance();
        $this->paths = $this->WWCrmService->get('paths');
    }

    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('t', [$this, 't']),
        ];
    }

    public function t($array) {
        $builder = new ComponentSelectBuilder();
        $builder->fromArray($array);
        return $builder->toArray();
    }
}