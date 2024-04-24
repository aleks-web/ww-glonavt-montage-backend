<?php

namespace WWCrm\Services;

// Сервис контейнер DI
use WWCrm\ServiceContainer;

// Пользователи
use WWCrm\Models\Organizations;

// Компоненты
use WWCrm\Services\ComponentSelectBuilder;

final class OrganizationService {

    protected $WWCrmService;
    protected $session;
    protected $paths;
    protected $imageManager;

    public function __construct() {
        $this->WWCrmService = ServiceContainer::getInstance(); // Получаем контейнер
        $this->session = $this->WWCrmService->get('SymfonySession'); // Получаем сессии
        $this->paths = $this->WWCrmService->get('paths');
        $this->imageManager = $this->WWCrmService->get('ImageManager');
    }

    /*
        Получить html отрендеренный компонент со списком пользователей
    */
    public function getComponentSelect(string $component_input_name = null, bool $required = null) : false|string {

        if (empty($component_input_name) || empty($required)) {
            return false;
        }

        $componentBuilder = new ComponentSelectBuilder($component_input_name, $required);

        foreach (Organizations::all() as $client) {
            $componentBuilder->addIdItem($client->id)->addTextItem($client->name)->saveItem();
        }

        return $componentBuilder->toHtml();
    }
}