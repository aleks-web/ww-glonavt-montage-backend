<?php

$base_path = realpath(dirname(__DIR__));
$public_html = realpath($base_path . '/public_html');

// Дирректории загрузок
$uploads_files = realpath($public_html . '/upload_files');
$users_avatars = realpath($uploads_files . '/users/avatars');
$object_photos = realpath($uploads_files . '/objects/photos');

$organizations_contracts = realpath($uploads_files . '/organizations/contracts');
$organizations_bills = realpath($uploads_files . '/organizations/bills');

return [
    'paths' => [
        /*
            Названия путей в файловой системе
        */
        'fs' => [
            'base_path' => $base_path,
            'public_html' => $public_html,
            'uploads_files' => $uploads_files,
            'users_avatars' => $users_avatars,
            'object_photos' => $object_photos,
            'organizations_contracts' => $organizations_contracts,
            'organizations_bills' => $organizations_bills
        ],

        /*
            Названия путей для отображения на фронте
        */
        'public' => [
            'assets' => '/assets',
            'default_images' => '/assets/img/default',
            'users_avatars' => '/upload_files/users/avatars',
            'object_photos' => '/upload_files/objects/photos',
        ],


    ]
];