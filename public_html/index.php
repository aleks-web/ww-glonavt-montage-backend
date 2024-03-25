<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once 'bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


// Start Инициализируем проутер через сервис контейнер
$router = $WWAppContainer->get('Router');
// End Инициализируем проутер через сервис контейнер

// $WWAppContainer->get('CurrentUser')->get();


// Start Routes
$router->get('/', 'MainController'); // Главная страница. Обработка в __invoke методе

$router->get('/clients', 'ClientsController'); // Клиенты
$router->get('/applications', 'ApplicationsController'); // Заявки
$router->get('/statistics', 'StatisticsController'); // Статистика
$router->get('/objects', 'ObjectsController'); // Объекты
$router->get('/workers', 'WorkersController'); // Сотрудники

// Справочники
$router->get('/book-equipment', 'BookEquipmentsController'); // Оборудование

$router->get('/404', 'MainController@notFound'); // Страница не найдена

$router->notFound(function(Request $request, Response $response) {
    header('Location: ' . $request->server->get('REQUEST_SCHEME') . '://' . $request->server->get('HTTP_HOST') . '/404');
});

$router->error(function(Request $request, Response $response) {
    $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    $response->setContent('Возникла ошибка. Возможно twig');
    return $response;
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