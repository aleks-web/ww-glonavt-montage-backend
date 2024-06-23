<?php


// В роутах index.php и api.php нужно брать отсюда. Новая версия

return ['routs' => [
    'api_v1' => [
        'ClientsBills' => [ // Счета клиентов
            'create' => [
                'route' => '/api_v1/clients/bills/create/',
                'controller' => 'WWCrm\Controllers\Clients\Bills\ApiClientsBillsController@create'
            ],
            'delete' => [
                'route' => '/api_v1/clients/bills/delete/',
                'controller' => 'WWCrm\Controllers\Clients\Bills\ApiClientsBillsController@delete'
            ],
            'update' => [
                'route' => '/api_v1/clients/bills/update/',
                'controller' => 'WWCrm\Controllers\Clients\Bills\ApiClientsBillsController@update'
            ]
        ],
        'ClientsContracts' => [ // Договоры клиентов
            'create' => [
                'route' => '/api_v1/clients/contracts/create/',
                'controller' => 'WWCrm\Controllers\Clients\Contracts\ApiClientsContractsController@create'
            ],
            'delete' => [
                'route' => '/api_v1/clients/contracts/delete/',
                'controller' => 'WWCrm\Controllers\Clients\Contracts\ApiClientsContractsController@delete'
            ],
            'update' => [
                'route' => '/api_v1/clients/contracts/update/',
                'controller' => 'WWCrm\Controllers\Clients\Contracts\ApiClientsContractsController@update'
            ]
        ],
        'Clients' => [ // Клиенты
            'create' => [
                'route' => '/api_v1/clients/create/',
                'controller' => 'WWCrm\Controllers\Clients\ApiClientsController@create'
            ],
            'update' => [
                'route' => '/api_v1/clients/update/',
                'controller' => 'WWCrm\Controllers\Clients\ApiClientsController@update'
            ],
            'create_contact_person' => [
                'route' => '/api_v1/clients/contacts-persons/create/',
                'controller' => 'WWCrm\Controllers\Clients\ApiClientsController@create_contacts_person'
            ],
            'update_contact_person' => [
                'route' => '/api_v1/clients/contacts-persons/update/',
                'controller' => 'WWCrm\Controllers\Clients\ApiClientsController@update_contacts_person'
            ],
            'remove_contact_person' => [
                'route' => '/api_v1/clients/contacts-persons/remove/',
                'controller' => 'WWCrm\Controllers\Clients\ApiClientsController@remove_contacts_person'
            ],
            'render' => [
                'route' => '/api_v1/clients/render/',
                'controller' => 'WWCrm\Controllers\Clients\ApiClientsController@distributor'
            ]
        ],
        'Objects' => [ // Объекты
            'render' => [
                'route' => '/api_v1/objects/render/',
                'controller' => 'WWCrm\Controllers\Objects\ApiObjectsController@render'
            ],
        ],
        'ObjectsDocs' => [ // Документы объектов
            'create' => [
                'route' => '/api_v1/objects/docs/create/',
                'controller' => 'WWCrm\Controllers\Objects\Docs\ApiObjectsDocsController@create'
            ],
            'update' => [
                'route' => '/api_v1/objects/docs/update/',
                'controller' => 'WWCrm\Controllers\Objects\Docs\ApiObjectsDocsController@update'
            ],
            'delete' => [
                'route' => '/api_v1/objects/docs/delete/',
                'controller' => 'WWCrm\Controllers\Objects\Docs\ApiObjectsDocsController@delete'
            ]
        ],
        'Applications' => [ // Заявки
            'create' => [
                'route' => '/api_v1/applications/create/',
                'controller' => 'WWCrm\Controllers\Applications\ApiApplicationsController@create'
            ],
            'update' => [
                'route' => '/api_v1/applications/update/',
                'controller' => 'WWCrm\Controllers\Applications\ApiApplicationsController@update'
            ],
            'render' => [
                'route' => '/api_v1/applications/render/',
                'controller' => 'WWCrm\Controllers\Applications\ApiApplicationsController@distributor'
            ],
        ],
        'BookServices' => [
            'create' => [
                'route' => '/api_v1/book-services/create/',
                'controller' => 'WWCrm\Controllers\Books\ApiBookServicesController@create'
            ],
            'update' => [
                'route' => '/api_v1/book-services/update/',
                'controller' => 'WWCrm\Controllers\Books\ApiBookServicesController@update'
            ],
            'delete' => [
                'route' => '/api_v1/book-services/delete/',
                'controller' => 'WWCrm\Controllers\Books\ApiBookServicesController@delete'
            ],
            'render' => [
                'route' => '/api_v1/book-services/render/',
                'controller' => 'WWCrm\Controllers\Books\ApiBookServicesController@distributor'
            ],
        ],
        'DaData' => [ // Сервис DaData
            'check_org_by_inn' => [
                'route' => '/api_v1/dadata/check_org_by_inn/',
                'controller' => 'WWCrm\Controllers\DaData\ApiDaDataController@check_org_by_inn'
            ],
            'check_bank_by_bic' => [
                'route' => '/api_v1/dadata/check_bank_by_bic/',
                'controller' => 'WWCrm\Controllers\DaData\ApiDaDataController@check_bank_by_bic'
            ],
        ],
    ],
]];