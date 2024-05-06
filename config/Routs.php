<?php

return ['routs' => [
    'api_v1' => [
        'ClientsContracts' => [
            'create' => [
                'route' => '/api_v1/clients/contracts/create/',
                'controller' => 'WWCrm\Controllers\Clients\Contracts\ApiClientsContractsController@create'
            ],
            'delete' => [
                'route' => '/api_v1/clients/contracts/delete/',
                'controller' => 'WWCrm\Controllers\Clients\Contracts\ApiClientsContractsController@delete'
            ]
        ],

        'Clients' => [
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
        ]
    ]
]];