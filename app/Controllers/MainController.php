<?php

namespace WWCrm\Controllers;

use Buki\Router\Http\Controller;

use WWCrm\ServiceContainer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller {

    protected $WWCrmService;
    protected $WWCurrentUser;
    protected $view; // Twig
    protected $session; // Сессии
    protected $paths; // Пути
    protected $imageManager; // Для работы с изображениями

    protected $userService;

    // Сервисы клиентов
    protected $organizationService;
    protected $orgContractService;
    protected $orgBillService;

    // Сервисы объектов
    protected $objectService;
    protected $objDocService;


    protected $utils;

    public function __construct() {
        $this->WWCrmService = ServiceContainer::getInstance();
        $this->WWCurrentUser = $this->WWCrmService->get('CurrentUser');
        $this->view = $this->WWCrmService->get('View');
        $this->session = $this->WWCrmService->get('SymfonySession');
        $this->paths = $this->WWCrmService->get('paths');
        $this->imageManager = $this->WWCrmService->get('ImageManager');

        $this->objectService = $this->WWCrmService->get('ObjectService');
        $this->organizationService = $this->WWCrmService->get('OrganizationService');
        $this->orgContractService = $this->WWCrmService->get('OrgContractService');
        $this->orgBillService = $this->WWCrmService->get('OrgBillService');
        $this->userService = $this->WWCrmService->get('UserService');
        $this->objDocService = $this->WWCrmService->get('ObjDocService');

        $this->utils = $this->WWCrmService->get('Utils');
    }

    public function __invoke(Request $request, Response $response) {
        return $this->view->render('main.twig', [
            'title' => 'Тестовый layout',
        ]);
    }

    /*
        Функция транслита из русского в английский
    */
    public function translit(string | int $text) : string | int {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'ts',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        );
        
        return strtr($text, $converter);
    }

    public function getSlug(string | int $text, string $separator = '_') : string {
        return str_replace(' ', $separator, $this->translit($text));
    }

    /*
        Отправляем на 404 страницу, если не найдено
    */
    public function notFound() {
        return $this->WWCrmService->get('View')->render('404.twig');
    }
}