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
            new \Twig\TwigFunction('cpnt_select', [$this, 'cpnt_select']),
        ];
    }

    public function cpnt_select() {
        $builder = new ComponentSelectBuilder([
            'db_field_name' => 'test',
            'required' => false,
            'val' => 1,
            'title' => 'Title',
            'not_selected_text' => 'Нет',
            'position' => 'bottom',
            'input_messages_position' => 'top',
            'checkbox' => false

        ]);
        $builder->addIdItem(1)->addTextItem('text')->saveItem();
        return $builder->toArray();
    }
}