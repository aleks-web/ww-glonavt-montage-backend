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
        $response_array['cond'] = $condition;
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

}