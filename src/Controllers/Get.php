<?php

namespace WWCrm\Controllers;

use Buki\Router\Http\Controller;

use WWCrm\ServiceContainer;

class Get extends Controller {
    public function __invoke()
    {
        $WWCrmService = ServiceContainer::getInstance();

        return $WWCrmService->get('View')->render('main.twig', [
            'title' => 'test',
            'user' => [
                'name' => 'Алексей',
                'surname' => 'Антропов'
            ]
        ]);
    }

    public function get()
    {
        echo 'Hello from get!';
    }
}