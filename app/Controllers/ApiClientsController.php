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
use WWCrm\Models\Objects;
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
        Обновление организации
    */
    public function update(Request $request, Response $response) {

        // Получаем параметры
        $params = $request->request->all();
        $response_array['request_params'] = $params;

        // Обновляем оргонизацию
        $client = Organizations::find($params['id'])->update($params);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Данные клиента обновлены';

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
        } else if ($twig_element == 'fmodal-contact-person-update.twig') {
            return $this->render_fmodal_contact_person_update($twig_element, $request, $response);
        } else if ($twig_element == 'tab-content-objects.twig') {
            return $this->render_tab_objects($twig_element, $request, $response);
        } else {
            return 'Распределитель рендер запросов. Возврат пустого ответа';
        }
    }

    /*
        TWIG: modules/clients/render/main-table.twig
        Desc: Рендер главной таблицы
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

            foreach ($response_array['table_rows'] as $client) {
                $client->objects; // Получаем объекты. При обращении к свойству, каждая запись table_rows автоматически дополнится записями объектов
                $client->status_name = Organizations::getStatusName($client->status);
            }
            
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
        TWIG: modules/clients/render/modal-client.twig
        Desc: Рендер модалки просмотра клиента
    */
    public function render_modal_client($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        
        $client_id = $response_array['request_params']['client_id']; // Получаем id клиента из запроса

        if (!empty($twig_element) && !empty($client_id)) {
            $clientOriginalObject = Organizations::find($client_id);

            // Statuses
            $response_array['client_statuses'] = [
                'STATUS_NULL' => Organizations::STATUS_NULL,
                'STATUS_ACTIVE' => Organizations::STATUS_ACTIVE,
                'STATUS_ARCHIVE' => Organizations::STATUS_ARCHIVE,
            ];

            $response_array['client'] = Organizations::find($client_id); // $response_array['client'] для основного проброса. Тут делаем что-то с данными. Например заменяем статус клиента на читаемый вид
            $response_array['client']['contacts_persons'] = $response_array['client']->contactsPersons; // Получаем контактных лиц из другой таблицы

            // Заменяем статус с цифры на читаемый вид
            $response_array['client']['status_name'] = Organizations::getStatusName($response_array['client']['status']);
            
            // Start Формируем и прокидываем настроенный компонент статуса с выпадающим списком
            $StatusSelect = new ComponentSelectBuilder('status', true);
            $StatusSelect->setVal((int) $clientOriginalObject['status']);

            foreach(Organizations::getArrayStatuses() as $status_id => $status_name) { // Добавляем выгруженные элементы селект
                $StatusSelect->addIdItem($status_id)->addTextItem($status_name)->saveItem();
            }

            $response_array['twig_components_data']['status'] = $StatusSelect->toArray();

            // Настройки модалки
            $response_array['modal_settings'] = [
                'is_open' => $response_array['request_params']['is_open'],
            ];

            // Задаем директора
            $response_array['director'] = OrgContactsPersons::where([['organization_id', '=' , $client_id], ['post_id', '=', OrgContactsPersons::POST_STATUS_DIRECTOR]])->first();

            // End Формируем и прокидываем настроенный компонент статуса с выпадающим списком

            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $response_array['client'],
                'client_statuses' => $response_array['client_statuses'],
                'twig_components_data' => $response_array['twig_components_data'],
                'modal_settings' => $response_array['modal_settings'],
                'director' => $response_array['director']
            ]);

            $response_array['status'] = 'success';
        }




        // Итоговые манипуляции
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        // Возвращаем ответ
        return $response;
    }


    /*--- Start рендер вкладок в модалке "Просмотр клиента" */
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
            Рендер вкладки "Объекты". В модалке просмотра клиента
        */
        public function render_tab_objects($twig_element, Request $request, Response $response) {
            // Получаем параметры POST и сразу записываем их в массив с ответом
            $response_array['request_params'] = $request->request->all();
            $client_id = $response_array['request_params']['client_id'];

            $response_array['client'] = Organizations::find($client_id);
            $response_array['settings'] = [];

            if (empty($response_array['request_params']['condition_filtres'])) { // Если нет запроса на фильтрацию
                $response_array['objects'] = $response_array['client']->objects; // Получаем объекты
            } else { // Если есть то фильтруем
                $response_array['objects'] = Objects::where('organization_id', $client_id)
                                            ->where('gnum', 'like', '%' . $response_array['request_params']['condition_filtres'] . '%')
                                            ->orWhere('brand', 'like', '%' . $response_array['request_params']['condition_filtres'] . '%')
                                            ->orWhere('model', 'like', '%' . $response_array['request_params']['condition_filtres'] . '%')
                                            ->get();
                $response_array['settings']['is_filtres'] = true;
            }

            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'objects' => $response_array['objects'],
                'settings' => $response_array['settings']
            ]);

            $response_array['status'] = 'success';

            // Итоговые манипуляции
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            // Возвращаем ответ
            return $response;
        }
    /*--- End рендер вкладок в модалке "Просмотр клиента" */


    /*--- Start Модалка fmodal Новое контактное лицо */
        /*
            Рендер модалки "Новое контактное лицо - добавление"
        */
        public function render_fmodal_new_contact_person($twig_element, Request $request, Response $response) {
            // Получаем параметры POST и сразу записываем их в массив с ответом
            $response_array['request_params'] = $request->request->all();
            $response_array['client'] = Organizations::find($response_array['request_params']['client_id']); // Получаем клиента
            $response_array['contacts_persons'] = $response_array['client']->contactsPersons;

            $response_array['contacts_person_posts'] = [
                'POST_STATUS_DIRECTOR' => OrgContactsPersons::POST_STATUS_DIRECTOR,
                'POST_STATUS_DEFAULT' => OrgContactsPersons::POST_STATUS_DEFAULT
            ];

            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $response_array['client'],
                'contacts_persons' => $response_array['contacts_persons'],
                'contacts_person_posts' => $response_array['contacts_person_posts']
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
            $response_array['client'] = Organizations::find($response_array['person']['organization_id']);
            $response_array['contacts_persons'] = $response_array['client']->contactsPersons;
            
            $response_array['contacts_person_posts'] = [
                'POST_STATUS_DIRECTOR' => OrgContactsPersons::POST_STATUS_DIRECTOR,
                'POST_STATUS_DEFAULT' => OrgContactsPersons::POST_STATUS_DEFAULT
            ];

            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'person' => $response_array['person'], // Прокидываем персону
                'contacts_persons' => $response_array['contacts_persons'],
                'contacts_person_posts' => $response_array['contacts_person_posts']
            ]);

            $response_array['status'] = 'success';

            // Итоговые манипуляции
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            // Возвращаем ответ
            return $response;
        }
    /*--- End Модалка fmodal Новое контактное лицо */
}