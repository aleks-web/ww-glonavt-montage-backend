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
use WWCrm\Models\BookDocs;

class ApiBookDocsController extends \WWCrm\Controllers\MainController {

    /*
        Создание типа документа
    */
    public function delete(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешное удаление типа документа';

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Удаление типа документа
    */
    public function delete(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $countDocs = BookDocs::all()->count();

        if ($countDocs === 1) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Остался всего 1 тип документа. Его нельзя удалить';
        } else {
            if(BookDocs::find($params['id'])->delete()) {
                $response_array['status'] = 'success';
                $response_array['message'] = 'Успешное удаление типа документа';
            } else {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Не удалось удалить тип документа';
            }
        }

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
        Рендер главной таблицы main-table.twig
    */
    public function render_main_table($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        if ($condition = $params['control_panel_condition']) {
            $response_array['docs'] = BookDocs::where('name', 'like', "%$condition%")->get();
        } else {
            $response_array['docs'] = BookDocs::all();
        }

        $response_array['render_response_html'] = $this->view->render('books/docs/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'docs' => $response_array['docs']
        ]);

        $response_array['status'] = 'success';
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

}