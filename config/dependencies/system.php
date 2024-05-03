<?php

return [
    'View' => function (\Psr\Container\ContainerInterface $container) {
        $twig =  new \Twig\Environment($container->get('TwigFilesystemLoader'), [
            // 'cache' => realpath(dirname(dirname(__DIR__)) . '/templates/compilation_cache'),
            'debug' => true
        ]);

        $twig->addExtension($container->get('TwigExtensionDebugExtension'));
        $twig->addExtension($container->get('TwigExtensionDd'));
        $twig->addExtension($container->get('TwigExtensionCurrentUser'));

        return $twig;
    },

    'TwigFilesystemLoader' => \DI\Factory(function() {
        return new \Twig\Loader\FilesystemLoader(realpath(dirname(dirname(__DIR__)) . '/templates'));
    }),

    'TwigExtensionDebugExtension' => \DI\Factory(function() {
        return new \Twig\Extension\DebugExtension();
    }),
    
    'TwigExtensionDd' => \DI\Factory(function() {
        return new WWCrm\Others\Twig\Extensions\DdTwigExtension();
    }),

    'TwigExtensionCurrentUser' => \DI\Factory(function() {
        return new WWCrm\Others\Twig\Extensions\CurrentUserTwigExtension();
    }),

    'Router' => function (\Psr\Container\ContainerInterface $container) {
        return new \Buki\Router\Router([
            'paths' => [
                'controllers' => realpath(dirname(dirname(__DIR__)) . '/app/Controllers'),
                'middlewares' => realpath(dirname(dirname(__DIR__)) . '/app/Middlewares')
            ],
            'namespaces' => [
                'controllers' => 'WWCrm\Controllers',
                'middlewares' => 'WWCrm\Middlewares'
            ]
        ]);
    },

    'CurrentUser' => function (\Psr\Container\ContainerInterface $container) {
        return new \WWCrm\Services\CurrentUser();
    },

    'SymfonySession' => function () {
        return new \Symfony\Component\HttpFoundation\Session\Session();
    },

    'InterventionGdDriver' => \DI\Factory(function() {
        return new \Intervention\Image\Drivers\Gd\Driver();
    }),

    'ImageManager' => function (\Psr\Container\ContainerInterface $container) {
        return new \Intervention\Image\ImageManager($container->get('InterventionGdDriver'));
    },

    'Utils' => function () {
        return new \WWCrm\Utils();
    },

    'OrganizationService' => function () {
        return new \WWCrm\Services\Organization\OrganizationService();
    },
    'ObjectService' => function () {
        return new \WWCrm\Services\Object\ObjectService();
    },
    'UserService' => function () {
        return new \WWCrm\Services\User\UserService();
    },

];