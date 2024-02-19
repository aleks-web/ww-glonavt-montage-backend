<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once realpath(dirname(__DIR__) . '/vendor/autoload.php');

use WWCrm\ServiceContainer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$WWAppContainer = ServiceContainer::getInstance();

// Start Инициализируем проутер через сервис контейнер
$router = $WWAppContainer->get('Router');
// End Инициализируем проутер через сервис контейнер

// Start Routes
$router->get('/', 'Get');
// End Routes

$router->run();

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