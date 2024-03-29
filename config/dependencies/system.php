<?php

return [
    'View' => function (\Psr\Container\ContainerInterface $container) {
        $twig =  new \Twig\Environment($container->get('TwigFilesystemLoader'), [
            // 'cache' => realpath(dirname(dirname(__DIR__)) . '/templates/compilation_cache'),
            'debug' => true
        ]);

        $twig->addExtension($container->get('TwigExtensionDebugExtension'));

        return $twig;
    },

    'TwigFilesystemLoader' => \DI\Factory(function() {
        return new \Twig\Loader\FilesystemLoader(realpath(dirname(dirname(__DIR__)) . '/templates'));
    }),

    'TwigExtensionDebugExtension' => \DI\Factory(function() {
        return new \Twig\Extension\DebugExtension();
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
    }
];