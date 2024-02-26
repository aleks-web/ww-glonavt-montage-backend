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
$router->xpost(API_V1_URL . 'clients/create', 'ApiClientsController@create');
$router->xpost(API_V1_URL . 'clients/render', 'ApiClientsController@render');


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