<?php

namespace WWCrm\Controllers\Books;

/* 
    Компоненты Symfony запрос и ответ
    https://symfony.ru/doc/current/components/http_foundation.html
*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Модельки
use WWCrm\Models\BookServices;

class ApiBookServicesController extends \WWCrm\Controllers\MainController {

    /*
        Создание типа услуги
    */
    public function create(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        BookServices::create($params);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешное создание нового типа услуги';

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Обновление типа услуги
    */
    public function update(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        BookServices::find($params['id'])->update($params);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешное обновление типа услуги';

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Удаление типа услуги
    */
    public function delete(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $countObjects = BookServices::all()->count();

        if ($countObjects === 1) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Остался всего 1 тип услуги. Его нельзя удалить';
        } else {
            if(BookServices::find($params['id'])->delete()) {
                $response_array['status'] = 'success';
                $response_array['message'] = 'Успешное удаление типа услуги';
            } else {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Не удалось удалить тип услуги';
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
        } else if ($twig_element == 'fmodal-book-service-update.twig') {
            return $this->render_fmodal_book_service_update($twig_element, $request, $response);
        } else if ($twig_element == 'fmodal-book-new-service.twig') {
            return $this->render_fmodal_book_new_service($twig_element, $request, $response);
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
            $response_array['services'] = BookServices::where('name', 'like', "%$condition%")->get();
        } else {
            $response_array['services'] = BookServices::all();
        }

        $response_array['render_response_html'] = $this->view->render('books/services/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'services' => $response_array['services']
        ]);

        $response_array['status'] = 'success';
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Рендер fmodal-book-service-update.twig
    */
    public function render_fmodal_book_service_update($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $response_array['render_response_html'] = $this->view->render('books/services/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'service' => $response_array['service'] = BookServices::find($params['id'])
        ]);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешный рендер ' . $twig_element;
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Рендер fmodal-book-new-service.twig
    */
    public function render_fmodal_book_new_service($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $response_array['render_response_html'] = $this->view->render('books/services/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
        ]);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешный рендер ' . $twig_element;
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }
}