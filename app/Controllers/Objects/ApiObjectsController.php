<?php

namespace WWCrm\Controllers\Objects;

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
use WWCrm\Models\ObjLogs;
use WWCrm\Models\ObjDocs;
use WWCrm\Models\Objects;
use WWCrm\Models\BookObjects;

// DTO
use WWCrm\Dto\ObjectDto;

use Exception;

class ApiObjectsController extends \WWCrm\Controllers\MainController {

    /*
        ПРОТЕСТИТЬ!!!
        Создание объекта
    */
    public function create(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        $dto = new ObjectDto($params);

        // Если загрузили фото объекта
        if ($_FILES['object_photo']) {
            $dto->setObjectPhotoRequest($_FILES['object_photo']);
        }

        try {
            $object = $this->objectService->createObject($dto);

            if ($object && $_FILES['doc_file_0']) { // Тут надо отсортировать массив $_FILES
                $files_array = [];
                $file_index = 0;
                while (!empty($_FILES['doc_file_' . $file_index])) {
                    $files_array[$file_index] = $_FILES['doc_file_' . $file_index];
                    $file_index = $file_index + 1;
                }

                $this->objDocService->createDocsFromArraysRequest($files_array, $object->id);
            }

            $response_array['object'] = $object;
            $response_array['status'] = 'success';
            $response_array['message'] = 'Объект создан';
            $response_array['_FILES'] = $_FILES;
        } catch (Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Объект не удалось создать';
            $response_array['exception_message'] = $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }


    /*
        Метод обновления объекта
    */
    public function update(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        $dto = new ObjectDto($params);

        try {
            if ($this->objectService->updateObject($dto)) {
                $response_array['object'] = $object;
                $response_array['status'] = 'success';
                $response_array['message'] = 'Объект обновлен';
                $response_array['dto'] = $dto->toArray();
            } else {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Не удалось создать объект';
            }
        } catch (Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Объект не удалось создать';
            $response_array['exception_message'] = $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Добавляет новое оборудование из справочника.
        Добавляется не в родную, а служебную (смежную) таблицу. Модель - ObjEquipments
    */
    public function add_new_equipment(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $object_id = $response_array['request_params']['object_id'];
        $equipment_id = $response_array['request_params']['equipment_id'];

        $hasEquipment = ObjEquipments::where('object_id', '=', $object_id)->where('equipment_id', '=', $equipment_id)->get();

        if (count($hasEquipment) <= 0) {
            ObjEquipments::create($response_array['request_params']);
            $response_array['status'] = 'success';
            $response_array['test'] = $hasEquipment;
            $response_array['message'] = 'Успешное добавление оборудования к объекту ' . $response_array['request_params']['object_id'];
        
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Данное оборудование уже добавлено';
            $response_array['test'] = $hasEquipment;
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }

    }

    /*
        Добавляет новый девайс для объекта
    */
    public function add_new_device(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        // Получаем id
        $object_id = $response_array['request_params']['object_id'];
        $equipment_id = $response_array['request_params']['equipment_id'];
        $fields_data = json_decode($response_array['request_params']['fields_data']); // Данные с полей с девайсом


        /*
            Проверка на заполнение
            Хотя бы что-то должно быть заполнено
        */
        $fields_data_empty = true;
        foreach ($fields_data as $data) {
            if (!empty($data->val)) {
                $fields_data_empty = false;
            }
        }

        if ($fields_data_empty) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили ни одного поля';
    
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
    
            return $response;
        }
        // End проверка на заполнение

        $ObjEquipment = ObjEquipments::where(['object_id' => $object_id])->where(['equipment_id' => $equipment_id])->first();
        
        $new_fields_data = $ObjEquipment['field_properties_data'];
        $new_fields_data = $new_fields_data ? json_decode($new_fields_data) : []; // Если пусто, то создаем массив, иначе просто декодируем его
        array_push($new_fields_data, $fields_data); // Пушим в массив запрос с данными дейвайса


        $new_fields_data = json_encode($new_fields_data, JSON_UNESCAPED_UNICODE);
        $ObjEquipment->update(['field_properties_data' => $new_fields_data]);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Оборудование успешно добавлено';
        $response_array['obj_equipment'] = $ObjEquipment;

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

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
        } else if ($twig_element == 'fmodal-new-objdoc.twig') {
            return $this->render_fmodal_new_objdoc($twig_element, $request, $response);
        } else if ($twig_element == 'fmodal-objdoc-update.twig') {
            return $this->render_fmodal_objdoc_update($twig_element, $request, $response);
        } else if ($twig_element == 'tab-content-equipments.twig') {
            return $this->render_tab_content_equipments($twig_element, $request, $response);
        } else if ($twig_element == 'tab-content-logs.twig') {
            return $this->render_tab_content_logs($twig_element, $request, $response);
        } else if ($twig_element == 'tab-content-gnum.twig') {
            return $this->render_tab_content_gnum($twig_element, $request, $response);
        } else if ($twig_element == 'tab-content-docs.twig') {
            return $this->render_tab_content_docs($twig_element, $request, $response);
        } else if($twig_element == 'fmodal-new-device.twig') {
            return $this->render_fmodal_new_device($twig_element, $request, $response);
        } else {
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
                $queryBuild->where('model', 'like', '%' . $condition . '%')
                            ->orWhere('brand', 'like', '%' . $condition . '%');
                $queryBuildNext->where('model', 'like', '%' . $condition . '%')
                                ->orWhere('brand', 'like', '%' . $condition . '%');
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
                $response_array['table_rows'][$key]['book_object_id'] = $object->objectType;
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


            $clientsBuilder = new ComponentSelectBuilder(['db_field_name' => 'organization_id', 'required' => true]);

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
        $response_array['organizations'] = Organizations::all();

        $orgBuilder = new ComponentSelectBuilder(['db_field_name' => 'organization_id', 'required' => true]);
        $orgBuilder->setDefaultText('Выберите клиента');
        foreach (Organizations::all() as $client) {
            $orgBuilder->addIdItem($client->id)->addTextItem($client->name)->saveItem();
        }
        $response_array['twig_components']['data']['clients'] = $orgBuilder->toArray();
        $response_array['twig_components']['html']['clients'] = $orgBuilder->toHtml();

        $bookBuilder = new ComponentSelectBuilder(['db_field_name' => 'book_object_id', 'required' => true]);
        $bookBuilder->setDefaultText('Выберите тип объекта');
        foreach (BookObjects::all() as $bookObj) {
            $bookBuilder->addIdItem($bookObj->id)->addTextItem($bookObj->name)->saveItem();
        }
        $response_array['twig_components']['data']['book_objects'] = $bookBuilder->toArray();
        $response_array['twig_components']['html']['book_objects'] = $bookBuilder->toHtml();

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'organizations' => $response_array['organizations'],
            'twig_components' => $response_array['twig_components']
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

        $equipmentsBuilder = new ComponentSelectBuilder(['db_field_name' => 'equipment_id', 'required' => true]);
        $equipmentsBuilder->setDefaultText('Не выбрано');
        foreach($book_equipments as $key => $equipment) {
            $equipmentsBuilder->addIdItem($equipment['id'])->addTextItem($equipment['name'])->saveItem();
        }
        $response_array['twig_components_data']['equipments'] = $equipmentsBuilder->toArray();

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'twig_components_data' => $response_array['twig_components_data']
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
    public function render_tab_content_equipments($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        // Получаем оборудование
        $response_array['equipments'] = ObjEquipments::where(['object_id' => $response_array['request_params']['object_id']])->get(); // Получаем все оборудование для объекта
        foreach ($response_array['equipments'] as $key => $equipment) {
            
            if(!empty($equipment['equipment_id'])) {
                $response_array['equipments'][$key]['name'] = $equipment->getBookEquipments['name']; // Получаем имя оборудования
            }

            if(!empty($response_array['equipments'][$key]['field_properties_data'])) {
                $response_array['equipments'][$key]['field_properties_data'] = json_decode($response_array['equipments'][$key]['field_properties_data']);
            }

            if(!empty($equipment['equipment_id'])) {
                $response_array['equipments'][$key]['field_properties'] = json_decode($equipment->getBookEquipments['field_properties']); // Записываем шаблон полей для ответа
            }
        }

        

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'equipments' => $response_array['equipments']
        ]);

        // Итоговые манипуляции
        $response_array['ttt'] = $response_array['equipments'];
        $response_array['status'] = 'success';
        $response_array['message'] = 'ApiObjectsController';
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер таба "Логи/История действий"
    */
    public function render_tab_content_logs($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'logs' => Objects::find($params['object_id'])->logs,
            'events_names' => ObjLogs::getArrayStatuses()
        ]);

        // Итоговые манипуляции
        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешный рендер ' . $twig_element;
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер таба "История гос.номеров"
    */
    public function render_tab_content_gnum($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'logs' => ObjLogs::where('object_id', '=', $params['object_id'])->where('event_id', '=', ObjLogs::EVENT_GNUM)->get(),
            'events_names' => ObjLogs::getArrayStatuses()
        ]);

        // Итоговые манипуляции
        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешный рендер ' . $twig_element;
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер модального окна "Добавить девайс"
    */
    public function render_fmodal_new_device($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        $response_array['equipment'] = BookEquipments::find($response_array['request_params']['equipment_id']); // Получаем оборудование
        $response_array['equipment']['field_properties'] = json_decode($response_array['equipment']['field_properties']); // Конвертируем в обычный массив

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'equipment' => $response_array['equipment']
        ]);

        $response_array['status'] = 'success';

        // Итоговые манипуляции
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер модального окна "Новый документ"
    */
    public function render_fmodal_new_objdoc($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
        ]);

        $response_array['status'] = 'success';

        // Итоговые манипуляции
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер модального окна "Редактирование документа"
    */
    public function render_fmodal_objdoc_update($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'doc' => ObjDocs::find($params['id'])
        ]);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешный рендер ' . $twig_element;

        // Итоговые манипуляции
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер таба "Документы"
    */
    public function render_tab_content_docs($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/objects/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'docs' => Objects::find($params['object_id'])->docs
        ]);

        // Итоговые манипуляции
        $response_array['status'] = 'success';
        $response_array['message'] = 'Успешный рендер ' . $twig_element;
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }
}