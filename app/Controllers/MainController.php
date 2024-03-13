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

    /*
        Отправляем на 404 страницу, если не найдено
    */
    public function notFound() {
        return $this->WWCrmService->get('View')->render('404.twig');
    }
}