<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once 'bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

const API_V1_URL = '/api_v1/';


// Start Инициализируем проутер через сервис контейнер
$router = $WWAppContainer->get('Router'); // Сервис роутинга
$controllers = $WWAppContainer->get('Controllers'); // Хранилище неймспейсов контрполлеров
// End Инициализируем проутер через сервис контейнер


// Start Routes
/*
    Роуты модуля "Клиенты"
*/
$router->xpost(API_V1_URL . 'clients/create', $controllers['Api']['Clients'] . '@create');
$router->xpost(API_V1_URL . 'clients/update', $controllers['Api']['Clients'] . '@update');
$router->xpost(API_V1_URL . 'clients/contacts-persons/create', $controllers['Api']['Clients'] . '@create_contacts_person'); // Роут создания контактного лица
$router->xpost(API_V1_URL . 'clients/contacts-persons/update', $controllers['Api']['Clients'] . '@update_contacts_person'); // Роут обновления контактного лица
$router->xpost(API_V1_URL . 'clients/contacts-persons/remove', $controllers['Api']['Clients'] . '@remove_contacts_person'); // Роут удаления контактного лица
$router->xpost(API_V1_URL . 'clients/render/:string', $controllers['Api']['Clients'] . '@distributor'); // Роут для рендера

/*
    Роуты модуля "Объекты"
*/
$router->xpost(API_V1_URL . 'objects/add-new-type-equipment', $controllers['Api']['Objects'] . '@add_new_equipment'); // Добавление оборудования
$router->xpost(API_V1_URL . 'objects/add-new-device', $controllers['Api']['Objects'] . '@add_new_device'); // Добавление девайса
$router->xpost(API_V1_URL . 'objects/render/:string', $controllers['Api']['Objects'] . '@distributor'); // Роут для рендера



// Book equipment
$router->xpost(API_V1_URL . 'book-equipment/render/:string', $controllers['Api']['BooksEquipments'] . '@distributor'); // Рендер оборудования
$router->xpost(API_V1_URL . 'book-equipment/update', $controllers['Api']['BooksEquipments'] . '@update'); // Обновление оборудования
$router->xpost(API_V1_URL . 'book-equipment/create', $controllers['Api']['BooksEquipments'] . '@create'); // Добавление нового типа оборудования


$router->notFound(function(Request $request, Response $response) {
    header('Location: ' . $request->server->get('REQUEST_SCHEME') . '://' . $request->server->get('HTTP_HOST') . '/404');
});
// End Routes



// Start Запускаем роутер
$router->run();
// End Запускаем роутер