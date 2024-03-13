<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once 'bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

const API_V1_URL = '/api_v1/';


// Start Инициализируем проутер через сервис контейнер
$router = $WWAppContainer->get('Router');
// End Инициализируем проутер через сервис контейнер


// Start Routes

/*
    Роуты модуля "Клиенты"
*/
$router->xpost(API_V1_URL . 'clients/create', 'ApiClientsController@create');
$router->xpost(API_V1_URL . 'clients/update', 'ApiClientsController@update');
$router->xpost(API_V1_URL . 'clients/contacts-persons/create', 'ApiClientsController@create_contacts_person'); // Роут создания контактного лица
$router->xpost(API_V1_URL . 'clients/contacts-persons/update', 'ApiClientsController@update_contacts_person'); // Роут обновления контактного лица
$router->xpost(API_V1_URL . 'clients/contacts-persons/remove', 'ApiClientsController@remove_contacts_person'); // Роут удаления контактного лица

/*
    Роуты модуля "Объекты"
*/
$router->xpost(API_V1_URL . 'objects/add-new-type-equipment', 'ApiObjectsController@add_new_equipment');


/*
    Роут рендеринга.
    :string - принимает название шаблона twig и далее прокидывается в контроллер.
    Контроллер рендерит и отдает ответ.
    Метод distributor - распределяет, на какой метод рендеринга отправить запрос
*/
$router->xpost(API_V1_URL . 'clients/render/:string', 'ApiClientsController@distributor');
$router->xpost(API_V1_URL . 'objects/render/:string', 'ApiObjectsController@distributor');


// Books
$router->xpost(API_V1_URL . 'book-equipment/render/:string', 'ApiBookEquipmentsController@distributor'); // Рендер оборудования
$router->xpost(API_V1_URL . 'book-equipment/update', 'ApiBookEquipmentsController@update'); // Обновление оборудования
$router->xpost(API_V1_URL . 'book-equipment/create', 'ApiBookEquipmentsController@create'); // Добавление нового типа оборудования


$router->notFound(function(Request $request, Response $response) {
    header('Location: ' . $request->server->get('REQUEST_SCHEME') . '://' . $request->server->get('HTTP_HOST') . '/404');
});
// End Routes



// Start Запускаем роутер
$router->run();
// End Запускаем роутер




//use WWCrm\Models\User;

// $users = new User();
// $users = $users::all();

// foreach ($users as $user) {
//     if ($user->articles->count()) {
//         echo "Посты для юзера: (id - $user->id) $user->name:<br>";
//     }

//     foreach ($user->articles as $article) {
//         dump($article);
//     }
// }