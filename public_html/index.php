<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once 'bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Start Инициализируем проутер через сервис контейнер
$router = $WWAppContainer->get('Router');
$controllers = $WWAppContainer->get('Controllers'); // Хранилище неймспейсов контрполлеров
// End Инициализируем проутер через сервис контейнер

// Start Routes
$router->get('/', $controllers['MainController']); // Главная страница. Обработка в __invoke методе

$router->get('/clients', $controllers['Default']['Clients'], ['before' => 'MainMiddleware']); // Клиенты
$router->get('/applications', $controllers['Default']['Applications']); // Заявки
$router->get('/statistics', $controllers['Default']['Statistics']); // Статистика
$router->get('/objects', $controllers['Default']['Objects']); // Объекты
$router->get('/workers', $controllers['Default']['Workers']); // Сотрудники

$router->get('/auth', $controllers['Default']['Auth']); // Авторизация

// Справочники
$router->get('/book-equipment', $controllers['Default']['BooksEquipments']); // Оборудование

// Страница не найдена
$router->notFound(function(Request $request, Response $response) {
    return \WWCrm\ServiceContainer::getInstance()->get('View')->render('404.twig');
});

$router->error(function(Request $request, Response $response, Exception $exception) {

    $error = [
        'error' => [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]
    ];

    foreach ($exception->getTrace() as $key => $tt) {
        $error['trace'][$key] = $tt;
    }

    // dd($error);

    return \WWCrm\ServiceContainer::getInstance()->get('View')->render('exception.twig', $error);

});
// End Routes

// Start Запускаем роутер
$router->run();
// End Запускаем роутер