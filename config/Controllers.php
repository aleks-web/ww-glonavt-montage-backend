<?php


return [
    'Controllers' => [
        'MainController' => 'WWCrm\Controllers\MainController',
        'Api' => [
            'Auth' => 'WWCrm\Controllers\Auth\ApiAuthController',
            'Clients' => 'WWCrm\Controllers\Clients\ApiClientsController',
            'Objects' => 'WWCrm\Controllers\Objects\ApiObjectsController',
            'BooksEquipments' => 'WWCrm\Controllers\Books\ApiBookEquipmentsController',
            'BooksDepartments' => 'WWCrm\Controllers\Books\ApiBookDepartmentsController'
        ],
        'Default' => [
            'Auth' => 'WWCrm\Controllers\Auth\AuthController',
            'Clients' => 'WWCrm\Controllers\Clients\ClientsController',
            'Objects' => 'WWCrm\Controllers\Objects\ObjectsController',
            'Applications' => 'WWCrm\Controllers\Applications\ApplicationsController',
            'Statistics' => 'WWCrm\Controllers\Statistics\StatisticsController',
            'Workers' => 'WWCrm\Controllers\Workers\WorkersController',
            'BooksEquipments' => 'WWCrm\Controllers\Books\BookEquipmentsController',
            'BooksDepartments' => 'WWCrm\Controllers\Books\BookDepartmentsController'
        ]
    ]
];