<?php

namespace WWCrm\Controllers;

use Buki\Router\Http\Controller;

use WWCrm\ServiceContainer;

class MainController extends Controller {

    protected $WWCrmService;
    protected $WWCurrentUser;
    protected $view;

    public function __construct() {
        $this->WWCrmService = ServiceContainer::getInstance();
        $this->WWCurrentUser = $this->WWCrmService->get('CurrentUser');
        $this->view = $this->WWCrmService->get('View');
    }

    /*
        Отправляем на 404 страницу, если не найдено
    */
    public function notFound() {
        return $this->WWCrmService->get('View')->render('404.twig');
    }
}