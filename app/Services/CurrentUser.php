<?php

namespace WWCrm\Services;

use WWCrm\ServiceContainer;

final class CurrentUser {

    protected $WWCrmService;
    protected $session;

    public function __construct() {
        $this->WWCrmService = ServiceContainer::getInstance(); // Получаем контейнер
        $this->session = $this->WWCrmService->get('SymfonySession'); // Получаем сессии
    }

    public function isAuterisation() {

    }

}