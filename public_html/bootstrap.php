<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once realpath(dirname(__DIR__) . '/vendor/autoload.php');

use WWCrm\ServiceContainer;

// Start Сервис контейнер
$WWAppContainer = ServiceContainer::getInstance();
// End Сервис контейнер

// Start Запуск сессии
$session = $WWAppContainer->get('SymfonySession');
$session->start();
// End Запуск сессии