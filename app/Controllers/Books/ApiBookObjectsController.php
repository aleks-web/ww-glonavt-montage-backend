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
use WWCrm\Models\BookObjects;

class ApiBookObjectsController extends \WWCrm\Controllers\MainController {

    /*
        Создание типа объекта
    */
    public function create(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        BookObjects::create($params);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешное создание типа объекта';

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Обновление типа объекта
    */
    public function update(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        BookObjects::find($params['id'])->update($params);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешное обновление типа объекта';

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Удаление типа объекта
    */
    public function delete(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $countObjects = BookObjects::all()->count();

        if ($countObjects === 1) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Остался всего 1 тип объекта. Его нельзя удалить';
        } else {
            if(BookObjects::find($params['id'])->delete()) {
                $response_array['status'] = 'success';
                $response_array['message'] = 'Успешное удаление типа объекта';
            } else {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Не удалось удалить тип объекта';
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
        } else if ($twig_element == 'fmodal-book-new-type-object.twig') {
            return $this->render_fmodal_book_new_type_object($twig_element, $request, $response);
        } else if ($twig_element == 'fmodal-book-type-object-update.twig') {
            return $this->render_fmodal_book_type_object_update($twig_element, $request, $response);
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
            $response_array['objects_types'] = BookObjects::where('name', 'like', "%$condition%")->get();
        } else {
            $response_array['objects_types'] = BookObjects::all();
        }

        $response_array['render_response_html'] = $this->view->render('books/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'objects_types' => $response_array['objects_types']
        ]);

        $response_array['status'] = 'success';
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Рендер fmodal-book-new-type-object.twig
    */
    public function render_fmodal_book_new_type_object($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $response_array['render_response_html'] = $this->view->render('books/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params']
        ]);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешный рендер ' . $twig_element;
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Рендер fmodal-book-type-object-update.twig
    */
    public function render_fmodal_book_type_object_update($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $response_array['object_type'] = BookObjects::find($params['id']);

        $response_array['render_response_html'] = $this->view->render('books/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'object_type' => $response_array['object_type']
        ]);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешный рендер ' . $twig_element;
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }
}