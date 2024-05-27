<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once 'bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

const API_V1_URL = '/api_v1/';


// Start Инициализируем проутер через сервис контейнер
$router = $WWAppContainer->get('Router'); // Сервис роутинга
$routs = $WWAppContainer->get('routs')['api_v1'];
$controllers = $WWAppContainer->get('Controllers'); // Хранилище неймспейсов контрполлеров
// End Инициализируем проутер через сервис контейнер


// Start Routes
/*
    Авторизация
*/
$router->xpost(API_V1_URL . 'auth/sign_in', $controllers['Api']['Auth'] . '@sign_in');
$router->xpost(API_V1_URL . 'auth/logout', $controllers['Api']['Auth'] . '@logout');
$router->xpost(API_V1_URL . 'auth/recovery', $controllers['Api']['Auth'] . '@recovery');


/*
    Пользователи системы
*/
$router->xpost(API_V1_URL . 'users/create/', $controllers['Api']['Users'] . '@create'); // Создание пользователя
$router->xpost(API_V1_URL . 'users/update/', $controllers['Api']['Users'] . '@update', ['before' => 'WWCrm\Middlewares\Users\UsersMiddleware']); // Обновление пользователя
$router->xpost(API_V1_URL . 'users/render/:string', $controllers['Api']['Users'] . '@distributor'); // Рендер элементов

/*
    Текущий пользователь
*/
$router->xpost(API_V1_URL . 'currentuser/update/', $controllers['Api']['CurrentUser'] . '@update'); // Обновление данных
$router->xpost(API_V1_URL . 'currentuser/render/:string', $controllers['Api']['CurrentUser'] . '@distributor'); // Рендер элементов

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
    Договоры клиентов
*/
$router->xpost(API_V1_URL . 'clients/contracts/create', $controllers['Api']['ClientsContracts'] . '@create'); // Создание договора
$router->xpost(API_V1_URL . 'clients/contracts/delete', $controllers['Api']['ClientsContracts'] . '@delete'); // Удаление договора
$router->xpost(API_V1_URL . 'clients/contracts/update', $controllers['Api']['ClientsContracts'] . '@update'); // Обновление договора

/*
    Счета клиентов
*/
$router->xpost(API_V1_URL . 'clients/bills/create', $controllers['Api']['ClientsBills'] . '@create'); // Создание счета
$router->xpost(API_V1_URL . 'clients/bills/delete', $controllers['Api']['ClientsBills'] . '@delete'); // Удаление счета
$router->xpost(API_V1_URL . 'clients/bills/update', $controllers['Api']['ClientsBills'] . '@update'); // Обновление счета



/*
    Роуты модуля "Объекты"
*/
$router->xpost(API_V1_URL . 'objects/add-new-type-equipment', $controllers['Api']['Objects'] . '@add_new_equipment'); // Добавление оборудования
$router->xpost(API_V1_URL . 'objects/add-new-device', $controllers['Api']['Objects'] . '@add_new_device'); // Добавление девайса
$router->xpost(API_V1_URL . 'objects/create', $controllers['Api']['Objects'] . '@create'); // Создание объекта
$router->xpost(API_V1_URL . 'objects/update', $controllers['Api']['Objects'] . '@update'); // Обновление объекта
$router->xpost(API_V1_URL . 'objects/render/:string', $controllers['Api']['Objects'] . '@distributor'); // Роут для рендера


/*
    Роуты для создания документа для Объекта
*/
$router->xpost($routs['ObjectsDocs']['create']['route'], $routs['ObjectsDocs']['create']['controller']); // Создание документа у объекта
$router->xpost($routs['ObjectsDocs']['delete']['route'], $routs['ObjectsDocs']['delete']['controller']); // Удаление документа у объекта


/*
    Роуты модуля "Сотрудники"
*/
$router->xpost(API_V1_URL . 'users/render/:string', $controllers['Api']['Users'] . '@distributor'); // Роут для рендера

// Book equipment
$router->xpost(API_V1_URL . 'book-equipment/render/:string', $controllers['Api']['BooksEquipments'] . '@distributor'); // Рендер оборудования
$router->xpost(API_V1_URL . 'book-equipment/update', $controllers['Api']['BooksEquipments'] . '@update'); // Обновление оборудования
$router->xpost(API_V1_URL . 'book-equipment/create', $controllers['Api']['BooksEquipments'] . '@create'); // Добавление нового типа оборудования

// Book departments
$router->xpost(API_V1_URL . 'book-departments/render/:string', $controllers['Api']['BooksDepartments'] . '@distributor'); // Рендер департаментов
$router->xpost(API_V1_URL . 'book-departments/delete', $controllers['Api']['BooksDepartments'] . '@delete'); // Удаление департамента
$router->xpost(API_V1_URL . 'book-departments/create', $controllers['Api']['BooksDepartments'] . '@create'); // Добавление департамента
$router->xpost(API_V1_URL . 'book-departments/update', $controllers['Api']['BooksDepartments'] . '@update'); // Обновление департамента

// Book posts
$router->xpost(API_V1_URL . 'book-posts/render/:string', $controllers['Api']['BooksPosts'] . '@distributor'); // Рендер должностей
$router->xpost(API_V1_URL . 'book-posts/delete', $controllers['Api']['BooksPosts'] . '@delete'); // Удаление должности
$router->xpost(API_V1_URL . 'book-posts/create', $controllers['Api']['BooksPosts'] . '@create'); // Создание должности
$router->xpost(API_V1_URL . 'book-posts/update', $controllers['Api']['BooksPosts'] . '@update'); // Обновление должности

// Book docs
$router->xpost(API_V1_URL . 'book-docs/delete', $controllers['Api']['BooksDocs'] . '@delete'); // Удаление типа документа
$router->xpost(API_V1_URL . 'book-docs/create', $controllers['Api']['BooksDocs'] . '@create'); // Создание типа документа
$router->xpost(API_V1_URL . 'book-docs/update', $controllers['Api']['BooksDocs'] . '@update'); // Обновление типа документа
$router->xpost(API_V1_URL . 'book-docs/render/:string', $controllers['Api']['BooksDocs'] . '@distributor'); // Рендер типов документов

// Book objects
$router->xpost(API_V1_URL . 'book-objects/delete', $controllers['Api']['BooksObjects'] . '@delete'); // Удаление типов объектов
$router->xpost(API_V1_URL . 'book-objects/create', $controllers['Api']['BooksObjects'] . '@create'); // Создание типов объектов
$router->xpost(API_V1_URL . 'book-objects/update', $controllers['Api']['BooksObjects'] . '@update'); // Обновление типов объектов
$router->xpost(API_V1_URL . 'book-objects/render/:string', $controllers['Api']['BooksObjects'] . '@distributor'); // Рендер типов объектов

$router->notFound(function(Request $request, Response $response) {
    header('Location: ' . $request->server->get('REQUEST_SCHEME') . '://' . $request->server->get('HTTP_HOST') . '/404');
});


$router->error(function(Request $request, Response $response, Exception $exception) {
    $response->headers->set('Content-Type', 'application/json');

    $error = [
        'error' => [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]
    ];

    $response->setContent(json_encode($error, JSON_UNESCAPED_UNICODE));
    return $response;

});
// End Routes



// Start Запускаем роутер
$router->run();
// End Запускаем роутер