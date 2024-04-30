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
    public function create(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        BookDocs::create($params);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешное создание типа документа';

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Обновление типа документа
    */
    public function update(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        BookDocs::find($params['id'])->update($params);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешное обновление типа документа';

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
        } else if ($twig_element == 'fmodal-book-new-type-doc.twig') {
            return $this->render_fmodal_book_new_type_doc($twig_element, $request, $response);
        } else if ($twig_element == 'fmodal-book-type-doc-update.twig') {
            return $this->render_fmodal_book_type_doc_update($twig_element, $request, $response);
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

    /*
        Рендер модалки fmodal-book-new-type-doc.twig
    */
    public function render_fmodal_book_new_type_doc($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $response_array['render_response_html'] = $this->view->render('books/docs/render/' . $twig_element, [
            'request_params' => $response_array['request_params']
        ]);

        $response_array['status'] = 'success';
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Рендер модалки fmodal-book-type-doc-update.twig
    */
    public function render_fmodal_book_type_doc_update($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();
        $response_array['doc'] = BookDocs::find($params['id']);

        $response_array['render_response_html'] = $this->view->render('books/docs/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'doc' => $response_array['doc']
        ]);

        $response_array['status'] = 'success';
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

}