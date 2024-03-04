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
use WWCrm\Models\OrgContactsPersons;
use WWCrm\Models\Users;

class ApiClientsController extends \WWCrm\Controllers\MainController {
    
    /*
        Создание организации
    */
    public function create(Request $request, Response $response) {

        // Получаем параметры
        $params = $request->request->all();

        // Создаем пользователя
        $client = Organizations::create($params);

        $response_array['client'] = Organizations::find($client->id);
        $response_array['status'] = 'success';
        $response_array['message'] = 'Клиент создан';
        $response_array['request_params'] = $params;

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Создание контактного лица организации
    */
    public function create_contacts_person(Request $request, Response $response) {
        
        // Получаем параметры
        $params = $request->request->all();

        // Создаем контактное лицо
        $contact_person = OrgContactsPersons::create($params);

        // Формируем ответ
        $response_array['contact_person'] = $contact_person;
        $response_array['status'] = 'success';
        $response_array['message'] = 'Контактное лицо создано';
        $response_array['request_params'] = $params;

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
        
    }

    /*
        Обновление контактного лица организации
    */
    public function update_contacts_person(Request $request, Response $response) {
        
        // Получаем параметры
        $params = $request->request->all();
        $response_array['request_params'] = $params;
        $id = $params['id'];
        unset($params['id']);

        // Создаем контактное лицо
        $contact_person = OrgContactsPersons::find($id)->update($params);
        $contact_person = OrgContactsPersons::find($id);

        // Формируем ответ
        $response_array['contact_person'] = $contact_person;
        $response_array['status'] = 'success';
        $response_array['message'] = 'Контактное лицо обновлено';

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
        
    }

    /*
        Удаление контактного лица организации
    */
    public function remove_contacts_person(Request $request, Response $response) {
        
        // Получаем параметры
        $params = $request->request->all();
        $response_array['request_params'] = $params;

        // Создаем контактное лицо
        OrgContactsPersons::find($params['person_id'])->delete();

        // Формируем ответ
        $response_array['status'] = 'success';
        $response_array['message'] = 'Контактное лицо удалено';

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
        
    }



    // Выступает в качестве распределителя
    public function distributor($twig_element, Request $request, Response $response) {
        $twig_element = $twig_element . '.twig';

        if ($twig_element == 'main-table.twig') {
            return $this->render_main_table($twig_element, $request, $response);
        } else if($twig_element == 'modal-client.twig') {
            return $this->render_modal_client($twig_element, $request, $response);
        } else if ($twig_element == 'tab-content-contacts-persons.twig') {
            return $this->render_tab_contacts_persons($twig_element, $request, $response);
        } else if($twig_element == 'fmodal-new-contact-person.twig') {
            return $this->render_fmodal_new_contact_person($twig_element, $request, $response);
        } else if ($twig_element == 'fmodal-contact-person-update.twig'){
            return $this->render_fmodal_contact_person_update($twig_element, $request, $response);
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
            $queryBuild = Organizations::offset($offset)->limit($per_page);
            $queryBuildNext = Organizations::offset($offset_next)->limit($per_page);
            
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
            
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
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
        Рендер модалки просмотра клиента
    */
    public function render_modal_client($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        
        $client_id = $response_array['request_params']['client_id']; // Получаем id клиента из запроса

        if (!empty($twig_element) && !empty($client_id)) {
            $clientOriginalObject = Organizations::find($client_id);

            $response_array['client'] = Organizations::find($client_id); // $response_array['client'] для основного проброса. Тут делаем что-то с данными. Например заменяем статус клиента на читаемый вид
            $response_array['client']['contacts_persons'] = $response_array['client']->contactsPersons; // Получаем контактных лиц из другой таблицы

            // Заменяем статус с цифры на читаемый вид
            $response_array['client']['status'] = Organizations::getStatusName($response_array['client']['status']);
            
            // Start Формируем и прокидываем настроенный компонент статуса с выпадающим списком
            $StatusSelect = new ComponentSelectBuilder('status', true);
            $StatusSelect->setVal((int) $clientOriginalObject['status']);

            foreach(Organizations::getArrayStatuses() as $status_id => $status_name) { // Добавляем выгруженные элементы селект
                $StatusSelect->addIdItem($status_id)->addTextItem($status_name)->saveItem();
            }

            $response_array['twig_components_data']['status'] = $StatusSelect->toArray();
            // End Формируем и прокидываем настроенный компонент статуса с выпадающим списком

            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $response_array['client'],
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
        Рендер вкладки "Контактные лица". В модалке просмотра клиента
    */
    public function render_tab_contacts_persons($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response_array['client'] = Organizations::find($response_array['request_params']['client_id']);
        $response_array['client']['contacts_persons'] = $response_array['client']->contactsPersons()->get();
        
        // Добавляем юзеров в массив | Инициаторы
        foreach ($response_array['client']['contacts_persons'] as $key => $person) {
            $id = $person['user_add_id'];

            $response_array['client']['contacts_persons'][$key]['user_add'] = Users::find($id);
        }

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'client' => $response_array['client']
        ]);

        $response_array['status'] = 'success';

        // Итоговые манипуляции
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер модалки "Новое контактное лицо"
    */
    public function render_fmodal_new_contact_person($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response_array['client'] = Organizations::find($response_array['request_params']['client_id']);

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'client' => $response_array['client']
        ]);

        $response_array['status'] = 'success';

        // Итоговые манипуляции
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }

    /*
        Рендер модалки "Новое контактное лицо - обновление"
    */
    public function render_fmodal_contact_person_update($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response_array['person'] = OrgContactsPersons::find($response_array['request_params']['person_id']);

        // Рендерим
        $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'person' => $response_array['person'] // Прокидываем персону
        ]);

        $response_array['status'] = 'success';

        // Итоговые манипуляции
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }
}