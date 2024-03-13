<?php

namespace WWCrm\Controllers;

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
use WWCrm\Models\BookEquipments;

class ApiBookEquipmentsController extends \WWCrm\Controllers\MainController {

    public function update(Request $request, Response $response) {
        // Получаем параметры
        $params = $request->request->all();
        $response_array['request_params'] = $params;

        // Обновляем оргонизацию
        $equipments = BookEquipments::find($params['id'])->update($params);

        $response_array['status'] = 'success';

        if($params['status'] == BookEquipments::STATUS_DELETED) {
            $response_array['message'] = 'Оборудование удалено';
        } else {
            $response_array['message'] = 'Оборудование обновлено';
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;

    }

    public function create(Request $request, Response $response) {
        // Получаем параметры
        $params = $request->request->all();
        $response_array['request_params'] = $params;

        $response->headers->set('Content-Type', 'application/json');

        if (!$response_array['request_params']['name']) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не ввели название оборудования';

            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }

        if (!$response_array['request_params']['name_1']) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не создали ни одного параметра';
            
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }

        $book_fields['name'] = $response_array['request_params']['name'];
        $book_fields['status'] = BookEquipments::STATUS_ACTIVE;
        $book_fields['field_properties'] = [];

        for ($i = 1; isset($response_array['request_params']['name_' . $i]); $i++) {
            if(isset($response_array['request_params']['name_' . $i]) && isset($response_array['request_params']['type_' . $i])) { // Если не пусто, то
                $book_fields['field_properties'][$i]['db_field_name'] = mb_strtolower(str_replace(' ', '_', $this->translit($response_array['request_params']['name_' . $i])));
                $book_fields['field_properties'][$i]['pls'] = $response_array['request_params']['name_' . $i];
                $book_fields['field_properties'][$i]['type'] = $response_array['request_params']['type_' . $i];
                $i++;
            } else {
                $response_array['status'] = 'error';
                $response_array['message'] = 'В одной из строк таблицы пустое значение';

                $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
                return $response;
            }
        }

        $book_fields['field_properties'] = array_values($book_fields['field_properties']);
        $book_fields['field_properties'] = json_encode($book_fields['field_properties'], JSON_UNESCAPED_UNICODE);

        BookEquipments::create($book_fields);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Оборудование успешно добавлено';
        $response_array['db_array'] = $book_fields;

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
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        // Start статуы
        $response_array['equipments_statuses']['STATUS_DELETED'] = BookEquipments::STATUS_DELETED;
        $response_array['equipments_statuses']['STATUS_ACTIVE'] = BookEquipments::STATUS_ACTIVE;

        if ($condition = $response_array['request_params']['control_panel_condition']) {
            $response_array['equipments'] = BookEquipments::where('name', 'like', "%$condition%")->get();
        } else {
            $response_array['equipments'] = BookEquipments::all();
        }

        foreach ($response_array['equipments'] as $key => $equipment) {
            $response_array['equipments'][$key]['objects'] = $equipment->objects;
        }

        $response_array['render_response_html'] = $this->view->render('books/equipments/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'equipments' => $response_array['equipments'],
            'equipments_statuses' => $response_array['equipments_statuses']
        ]);

        $response_array['status'] = 'success';
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

}