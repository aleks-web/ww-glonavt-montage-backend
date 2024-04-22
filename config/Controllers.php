<?php


return [
    'Controllers' => [
        'MainController' => 'WWCrm\Controllers\MainController',
        'Api' => [
            'Auth' => 'WWCrm\Controllers\Auth\ApiAuthController',
            'Users' => 'WWCrm\Controllers\Users\ApiUsersController',
            'Clients' => 'WWCrm\Controllers\Clients\ApiClientsController',
            'Objects' => 'WWCrm\Controllers\Objects\ApiObjectsController',
            'BooksEquipments' => 'WWCrm\Controllers\Books\ApiBookEquipmentsController',
            'BooksDepartments' => 'WWCrm\Controllers\Books\ApiBookDepartmentsController',
            'BooksPosts' => 'WWCrm\Controllers\Books\ApiBookPostsController'
        ],
        'Default' => [
            'Auth' => 'WWCrm\Controllers\Auth\AuthController',
            'Users' => 'WWCrm\Controllers\Users\UsersController',
            'Clients' => 'WWCrm\Controllers\Clients\ClientsController',
            'Objects' => 'WWCrm\Controllers\Objects\ObjectsController',
            'Applications' => 'WWCrm\Controllers\Applications\ApplicationsController',
            'Statistics' => 'WWCrm\Controllers\Statistics\StatisticsController',
            'BooksEquipments' => 'WWCrm\Controllers\Books\BookEquipmentsController',
            'BooksDepartments' => 'WWCrm\Controllers\Books\BookDepartmentsController',
            'BooksPosts' => 'WWCrm\Controllers\Books\BookPostsController'
        ]
    ]
];