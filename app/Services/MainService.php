<?php

namespace WWCrm\Services;

// Сервис контейнер DI
use WWCrm\ServiceContainer;

/*
    Главный сервис предназначет, чтобы инициализировать основноые компоненты из DI контейнера

    Этот экласс наследуется и расширяется
*/
class MainService {

    protected $WWCrmService;
    protected $imageManager;
    protected $session;
    protected $paths;
    protected $currentUser;
    protected $utils;
    protected $eventDisp;

    public function __construct() {
        $this->WWCrmService = ServiceContainer::getInstance(); // Получаем контейнер
        $this->imageManager = $this->WWCrmService->get('ImageManager'); // Обработка изображений
        $this->session = $this->WWCrmService->get('SymfonySession'); // Получаем сессии
        $this->paths = $this->WWCrmService->get('paths'); // Пути
        $this->currentUser = $this->WWCrmService->get('CurrentUser'); // Текущий пользователь
        $this->utils = $this->WWCrmService->get('Utils'); // Утильные методы
        $this->eventDisp = $this->WWCrmService->get('EventDispatcher'); // Диспатчер событий от Symfony
    }
}