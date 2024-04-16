<?php

namespace WWCrm\Controllers\Books;

/* 
    Компоненты Symfony запрос и ответ
    https://symfony.ru/doc/current/components/http_foundation.html
*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*
    Модели - 1 модель работает с 1 таблицей в БД
    Расширяют класс Model от Laravel
*/
use WWCrm\Models\BookDepartments;

class ApiBookDepartmentsController extends \WWCrm\Controllers\MainController {


    /*
        Метод удаления отдела
    */
    public function delete() {

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
        Рендер главной таблицы main-table.twig
    */
    public function render_main_table($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        $response_array['render_response_html'] = $this->view->render('books/departments/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'departments' => BookDepartments::all()
        ]);

        $response_array['status'] = 'success';
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

}