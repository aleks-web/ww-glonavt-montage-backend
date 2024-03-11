<?php

namespace WWCrm\Controllers;

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
use WWCrm\Services\ComponentSelectBuilder;



/*
    Модели - 1 модель работает с 1 таблицей в БД
    Расширяют класс Model от Laravel
*/
use WWCrm\Models\Organizations;
use WWCrm\Models\BookEquipments;
use WWCrm\Models\ObjEquipments;
use WWCrm\Models\Objects;

class ApiObjectsController extends \WWCrm\Controllers\MainController {

    /*
        Выступает в качестве распределителя
    */
    public function distributor($twig_element, Request $request, Response $response) {
        $twig_element = $twig_element . '.twig';

        if ($twig_element == 'main-table.twig') {
            return $this->render_main_table($twig_element, $request, $response);
        } else if ($twig_element == 'modal-object.twig') {
            return $this->render_modal_object($twig_element, $request, $response);
        } else if ($twig_element == 'modal-object-add.twig') {
            return $this->render_modal_objects_add($twig_element, $request, $response);
        } else if ($twig_element == 'fmodal-new-type-equipment.twig') {
            return $this->render_fmodal_new_type_equipment($twig_element, $request, $response);
        } else if ($twig_element == 'tab-content-equipments.twig') {
            return $this->tab_content_equipments($twig_element, $request, $response);
        }
        else {
            return 'Распределитель рендер запросов. Возврат пустого ответа';
        }
    }

    /*
        Рендер главной таблицы
    */
    public function render_main_table($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        if (!empty($twig_element)) { // Если есть рендер элемент

            // Start Данные для пагинации
            $current_page = !empty($response_array['request_params']['current_page']) ? (int) $response_array['request_params']['current_page'] : 1; // Текущая страница
            $per_page = 10; // Отображаемое количество на странице
            $offset = ($current_page - 1) * $per_page; // Offset для sql (пропуск выгрузки)
            $offset_next = $current_page * $per_page; // Offset для sql (пропуск для следующей страницы)

            // Говорим, что будем пропускать кол-во записей и выводить определенное
            // Начальное построение запроса
            $queryBuild = Objects::offset($offset)->limit($per_page);
            $queryBuildNext = Objects::offset($offset_next)->limit($per_page);
            
            if ($condition = $response_array['request_params']['control_panel_condition']) {
                $queryBuild->where('inn', 'like', '%' . $condition['name'] . '%')
                            ->orWhere('name', 'like', '%' . $condition['name'] . '%');
                $queryBuildNext->where('inn', 'like', '%' . $condition['name'] . '%')
                                ->orWhere('name', 'like', '%' . $condition['name'] . '%');
            }

            $response_array['pagination']['offset'] = $offset;
            $response_array['pagination']['per_page'] = $per_page;
            $response_array['pagination']['current_page'] = $current_page;
            $response_array['pagination']['next_page'] = $current_page + 1;
            $response_array['pagination']['prev_page'] = $current_page - 1;
            $response_array['pagination']['has_next_page'] = count($queryBuildNext->get()) ? true : false; // Есть ли следующая страница
            // End Данные для пагинации


            $response_array['status'] = 'success';
            $response_array['message'] = 'Элемент успешно отрендерился';
            $response_array['table_rows'] = $queryBuild->get();

            foreach ($response_array['table_rows'] as $key => $object) {
                $response_array['table_rows'][$key]['organization'] = Organizations::find($object['organization_id']);
            }
            
            $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
                'table_rows' => $response_array['table_rows'],
                'pagination' => $response_array['pagination'],
                'request_params' => $response_array['request_params']
            ]);

        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Twig элемент не найден в POST запросе. Проверьте отправляемые данные';
        }


        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Рендер модалки просмотра объекта
    */
    public function render_modal_object($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        
        $object_id = $response_array['request_params']['object_id']; // Получаем id объекта из запроса

        if (!empty($twig_element) && !empty($object_id)) {
            $objectOriginalObject = Objects::find($object_id);

            // $response_array['object'] для основного проброса. Тут делаем что-то с данными. Например заменяем статус клиента на читаемый вид
            $response_array['object'] = Objects::find($object_id);

            $response_array['object']['organization'] = Organizations::find($response_array['object']['organization_id']);
            $response_array['object']['user_added'] = $response_array['object']->userAdded; // Получаем данные пользователя, который добавил запись

            // Заменяем статус с цифры на читаемый вид
            $response_array['object']['status'] = Objects::getStatusName($response_array['object']['status']);


            $clientsBuilder = new ComponentSelectBuilder('organization_id', true);

            $response_array['twig_components_data']['clients'] = [];
            $clientsBuilder->setVal($response_array['object']['organization_id']);
            foreach(Organizations::get() as $key => $client) {
                $clientsBuilder->addIdItem($client['id'])->addTextItem($client['name'])->saveItem();
            }

            $response_array['twig_components_data']['clients'] = $clientsBuilder->toArray();

            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'object' => $response_array['object'],
                'twig_components_data' => $response_array['twig_components_data']
            ]);

            $response_array['status'] = 'success';
        }




        // Итоговые манипуляции
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер модалки добавление объекта
    */
    public function render_modal_objects_add($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            // 'twig_components_data' => $response_array['twig_components_data']
        ]);

        $response_array['status'] = 'success';

        // Итоговые манипуляции
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер модалки "Новое оборудование"
    */
    public function render_fmodal_new_type_equipment($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        $book_equipments = BookEquipments::where(['status' => BookEquipments::STATUS_ACTIVE])->get();
        $response_array['book_equipment'] = $book_equipments;

        $equipmentsBuilder = new ComponentSelectBuilder('equipment_id', true);
        foreach($book_equipments as $key => $equipment) {
            $equipmentsBuilder->addIdItem($equipment['id'])->addTextItem($equipment['name'])->saveItem();
        }
        $response_array['twig_components_data']['equipments'] = $equipmentsBuilder->toArray();

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'twig_components_data' => $response_array['twig_components_data']['equipments']
        ]);

        $response_array['status'] = 'success';

        // Итоговые манипуляции
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер таба "Оборудование"
    */
    public function tab_content_equipments($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        // Получаем оборудование
        $response_array['equipments'] = \WWCrm\Models\ObjEquipments::where(['object_id' => $response_array['request_params']['object_id']])->get();
        foreach ($response_array['equipments'] as $key => $equipment) {
            $response_array['equipments'][$key]['name'] = $equipment->getBookEquipments['name'];
            $response_array['equipments'][$key]['field_properties_data'] = json_decode($response_array['equipments'][$key]['field_properties_data']);
            $response_array['equipments'][$key]['field_properties'] = json_decode($equipment->getBookEquipments['field_properties']);
        }

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'equipments' => $response_array['equipments']
        ]);

        // Итоговые манипуляции
        $response_array['status'] = 'success';
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }
}