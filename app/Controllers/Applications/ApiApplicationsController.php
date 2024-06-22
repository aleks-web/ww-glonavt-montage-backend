<?php

namespace WWCrm\Controllers\Applications;

/* 
    Компоненты Symfony запрос и ответ
    https://symfony.ru/doc/current/components/http_foundation.html
*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* 
    ComponentSelectBuilder - Билдер компонента select
    Формирует массив с данными, который нужно прокинуть
    ООП обертка
*/
// use WWCrm\Services\ComponentSelectBuilder;


/*
    Модели - 1 модель работает с 1 таблицей в БД
    Расширяют класс Model от Laravel
*/


// Dto


class ApiApplicationsController extends \WWCrm\Controllers\MainController {
    
    /*
        Создание заявки
    */
    public function create(Request $request, Response $response) {
        $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }



    // Выступает в качестве распределителя
    public function distributor($twig_element, Request $request, Response $response) {
        $twig_element = $twig_element . '.twig';

        if ($twig_element == 'main-table.twig') {
            return $this->render_main_table($twig_element, $request, $response);
        } else {
            return 'Распределитель рендер запросов. Возврат пустого ответа';
        }
    }

    /*
        TWIG: modules/aplications/render/main-table.twig
        Desc: Рендер главной таблицы
    */
    public function render_main_table($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');
        
        $response_array['render_response_html'] = $this->view->render('modules/applications/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'applications' => \WWCrm\Models\Applications::all()
        ]);

        $response_array['status'] = "success";

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}