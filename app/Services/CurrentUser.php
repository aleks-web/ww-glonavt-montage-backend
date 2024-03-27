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

    /*
        Метод проверки на авторизованность пользователя
    */
    public function isAuterisation() {
        $user_id = $this->session->get('user_id');

        if (!$user_id) {
            return false;
        }

        return true;
    }

}