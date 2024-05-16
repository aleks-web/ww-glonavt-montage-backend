<?php


return [
    'Controllers' => [
        'MainController' => 'WWCrm\Controllers\MainController',
        'Api' => [
            'Auth' => 'WWCrm\Controllers\Auth\ApiAuthController',
            'Users' => 'WWCrm\Controllers\Users\ApiUsersController',
            'CurrentUser' => 'WWCrm\Controllers\CurrentUser\ApiCurrentUserController',
            'Clients' => 'WWCrm\Controllers\Clients\ApiClientsController',
            'ClientsContracts' => 'WWCrm\Controllers\Clients\Contracts\ApiClientsContractsController',
            'ClientsBills' => 'WWCrm\Controllers\Clients\Bills\ApiClientsBillsController',
            'Objects' => 'WWCrm\Controllers\Objects\ApiObjectsController',
            'BooksEquipments' => 'WWCrm\Controllers\Books\ApiBookEquipmentsController',
            'BooksDepartments' => 'WWCrm\Controllers\Books\ApiBookDepartmentsController',
            'BooksPosts' => 'WWCrm\Controllers\Books\ApiBookPostsController',
            'BooksDocs' => 'WWCrm\Controllers\Books\ApiBookDocsController',
            'BooksObjects' => 'WWCrm\Controllers\Books\ApiBookObjectsController'
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
            'BooksPosts' => 'WWCrm\Controllers\Books\BookPostsController',
            'BooksDocs' => 'WWCrm\Controllers\Books\BookDocsController',
            'BooksObjects' => 'WWCrm\Controllers\Books\BookObjectsController'
        ]
    ]
];