<?php

namespace WWCrm\Controllers;

use Buki\Router\Http\Controller;

use WWCrm\ServiceContainer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller {

    protected $WWCrmService;
    protected $WWCurrentUser;
    protected $view;

    public function __construct() {
        $this->WWCrmService = ServiceContainer::getInstance();
        $this->WWCurrentUser = $this->WWCrmService->get('CurrentUser');
        $this->view = $this->WWCrmService->get('View');
    }

    public function __invoke(Request $request, Response $response) {
        return $this->WWCrmService->get('View')->render('main.twig', [
            'title' => 'Тестовый layout',
        ]);
    }

    /*
        Отправляем на 404 страницу, если не найдено
    */
    public function notFound() {
        return $this->WWCrmService->get('View')->render('404.twig');
    }
}