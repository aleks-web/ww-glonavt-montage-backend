<?php

namespace WWCrm\Controllers\Clients;

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
use WWCrm\Models\OrgContracts;
use WWCrm\Models\OrgBills;
use WWCrm\Models\BookDocs;

/*
    Сервисы
*/
use WWCrm\Services\Organization\OrganizationService;

// Dto
use WWCrm\Dto\OrganizationDto;

use Exception;

class ApiClientsController extends \WWCrm\Controllers\MainController {
    
    /*
        Создание организации
    */
    public function create(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $request->request->all();

        // Создаем пользователя
        try {
            $clientDto = new OrganizationDto($params);

            $client = $this->organizationService->createOrganization($clientDto);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Клиент успешно создан';
            $response_array['client'] = $client;

            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Ошибка в базе данных';
                $response_array['exception_message'] = $e->getMessage();
            } else if ($e instanceof \Exception) {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Не удалось создать клиента';
                $response_array['exception_message'] = $e->getMessage();
            }

            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }
    }

    /*
        Обновление организации
    */
    public function update(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        
        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        $orgDto = new OrganizationDto($params);

        try {
            if ($params['event_name'] == 'change_status') {
                $this->organizationService->changeStatusOrganization($orgDto);
                $response_array['message'] = 'Статус клиента изменен';
            } else {
                $this->organizationService->updateOrganization($orgDto);
                $response_array['message'] = 'Успешное обновление данных клиента';
            }

            $response_array['status'] = 'success';
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        } catch (Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Не удалось обновить данные клиента';
            $response_array['exception_message'] = $e->getMessage();
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }
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
        } else if ($twig_element == 'fmodal-new-contract.twig') {
            return $this->render_fmodal_new_contract($twig_element, $request, $response);
        } else if($twig_element == 'fmodal-bill-update.twig') {
            return $this->render_fmodal_bill_update($twig_element, $request, $response);
        } else if ($twig_element == 'fmodal-contract-update.twig') {
            return $this->render_fmodal_contract_update($twig_element, $request, $response);
        } else if ($twig_element == 'fmodal-new-bill.twig') {
            return $this->render_fmodal_new_bill($twig_element, $request, $response);
        } else if ($twig_element == 'tab-content-objects.twig') {
            return $this->render_tab_objects($twig_element, $request, $response);
        } else if ($twig_element == 'modal-client-add.twig') {
            return $this->render_modal_client_add($twig_element, $request, $response);
        } else if($twig_element == 'tab-content-contracts.twig') {
            return $this->render_tab_contracts($twig_element, $request, $response);
        } else if($twig_element == 'tab-content-bills.twig') {
            return $this->render_tab_bills($twig_element, $request, $response);
        } else {
            return 'Распределитель рендер запросов. Возврат пустого ответа';
        }
    }

    /*
        TWIG: modules/clients/render/modal-client-add.twig
        Desc: Рендер модалки "Добавить клиента"
    */
    public function render_modal_client_add($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        if (!empty($twig_element)) { // Если есть рендер элемент

            $managerSelect = new ComponentSelectBuilder(['db_field_name' => 'manager_id', 'required' => true]);
            $managerSelect->setDefaultText('Ответственный менеджер');
            foreach(Users::all() as $user) { // Добавляем выгруженные элементы селект
                $managerSelect->addIdItem($user->id)->addTextItem($user->name)->saveItem();
            }
            
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'manager_select_html' => $managerSelect->toHtml(),
            ]);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Элемент успешно отрендерился';
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Twig элемент не найден в POST запросе. Проверьте отправляемые данные';
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        TWIG: modules/clients/render/main-table.twig
        Desc: Рендер главной таблицы
    */
    public function render_main_table($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

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

            $condition = $response_array['request_params']['control_panel_condition'];
            if ($condition['name'] || $condition['inn']) {
                $queryBuild->where('inn', 'like', '%' . $condition['name'] . '%')
                            ->orWhere('name', 'like', '%' . $condition['name'] . '%');
                $queryBuildNext->where('inn', 'like', '%' . $condition['name'] . '%')
                               ->orWhere('name', 'like', '%' . $condition['name'] . '%');
            }

            if ($condition['status']) {
                $queryBuild->where('status', '=', $condition['status']);
                $queryBuildNext->where('status', '=', $condition['status']);
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

            foreach ($response_array['table_rows'] as $key => $client) {
                $client->objects; // Получаем объекты. При обращении к свойству, каждая запись table_rows автоматически дополнится записями объектов
            }
            
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'table_rows' => $response_array['table_rows'],
                'statuses' => Organizations::getArrayStatuses(),
                'pagination' => $response_array['pagination'],
                'request_params' => $response_array['request_params']
            ]);

        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Twig элемент не найден в POST запросе. Проверьте отправляемые данные';
        }

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
            $response_array['client_statuses'] = Organizations::getArrayStatusesNamed();

            $response_array['client'] = Organizations::find($client_id); // $response_array['client'] для основного проброса. Тут делаем что-то с данными. Например заменяем статус клиента на читаемый вид
            $response_array['client']['contacts_persons'] = $response_array['client']->contactsPersons; // Получаем контактных лиц из другой таблицы
            $response_array['client']['manager'] = $response_array['client']->manager;

            // Заменяем статус с цифры на читаемый вид
            $response_array['client']['status_name'] = Organizations::getStatusName($response_array['client']['status']);
            
            // Start Формируем и прокидываем настроенный компонент статуса с выпадающим списком
            $StatusSelect = new ComponentSelectBuilder(['db_field_name' => 'status', 'required' => true]);
            $StatusSelect->setVal((int) $clientOriginalObject['status']);
            foreach(Organizations::getArrayStatuses() as $status_id => $status_name) { // Добавляем выгруженные элементы селект
                $StatusSelect->addIdItem($status_id)->addTextItem($status_name)->saveItem();
            }
            $response_array['twig_components_data']['status'] = $StatusSelect->toArray();


            $ManagersSelect = new ComponentSelectBuilder(['db_field_name' => 'manager_id', 'required' => false]);
            $ManagersSelect->setVal((int) $response_array['client']['manager']['id']);
            $ManagersSelect->setPosition('top');
            foreach(Users::all() as $manager_key => $manager) { // Добавляем выгруженные элементы селект
                $ManagersSelect->addIdItem($manager->id)->addTextItem($manager->name)->saveItem();
            }
            $ManagersSelect->setDefaultText('Менеджер не назначен');
            $response_array['twig_components_data']['managers'] = $ManagersSelect->toArray();

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

        /*
            Рендер вкладки "Договоры"
        */
        public function render_tab_contracts($twig_element, Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');

            // Получаем параметры POST и сразу записываем их в массив с ответом
            $params = $response_array['request_params'] = $request->request->all();
            $client_id = $response_array['request_params']['client_id'];

            $response_array['client'] = Organizations::find($client_id);
            $contracts = OrgContracts::where('organization_id', '=', $client_id)->get();

            foreach ($contracts as $key => $contract) {
                $contract->responsibleUser = $contract->responsibleUser;
                $contract->docType = OrgContracts::BOOK_TYPES;
            }

            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $response_array['client'],
                'contracts' => $contracts,
            ]);

            $response_array['status'] = 'success';

            // Итоговые манипуляции
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            // Возвращаем ответ
            return $response;
        }

        /*
            Рендер вкладки "Счета"
        */
        public function render_tab_bills($twig_element, Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');

            // Получаем параметры POST и сразу записываем их в массив с ответом
            $params = $response_array['request_params'] = $request->request->all();
            $client_id = $response_array['request_params']['client_id'];

            $response_array['client'] = Organizations::find($client_id);
            $response_array['client']['bills'] = $response_array['client']->bills;

            foreach($response_array['client']['bills'] as $bill) {
                $bill->userAdded();
            }

            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $response_array['client'],
                'bills_types' => OrgBills::getArrayStatuses()
            ]);

            $response_array['status'] = 'success';

            // Итоговые манипуляции
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            // Возвращаем ответ
            return $response;
        }
    /*--- End рендер вкладок в модалке "Просмотр клиента" */




    /*--- Start Модалка fmodal */
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

        /*
            Рендер модалки "Новый договор"
        */
        public function render_fmodal_new_contract($twig_element, Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');

            // Получаем параметры POST и сразу записываем их в массив с ответом
            $params = $response_array['request_params'] = $request->request->all();
            $client = Organizations::find($params['client_id']);

            $response_array['book_docs_db'] = BookDocs::all();
            $response_array['users_db'] = Users::all();

            $builderContractTypes = new ComponentSelectBuilder([
                'db_field_name' => 'doc_type_id',
                'required' => true,
                'not_selected_text' => 'Выберите договор'
            ]);
            foreach (OrgContracts::BOOK_TYPES as $idType => $nameType) {
                $builderContractTypes->addIdItem($idType)->addTextItem($nameType)->saveItem();
            }

            $builderUsers = new ComponentSelectBuilder([
                'db_field_name' => 'responsible_user_id',
                'required' => true,
                'not_selected_text' => 'Выберите ответственного'
            ]);
            foreach ($response_array['users_db'] as $user) {
                $builderUsers->addIdItem($user->id)->addTextItem($user->name)->saveItem();
            }
 
            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $client,
                'contract_types' => [
                    'select_html' => $builderContractTypes->toHtml(),
                    'select_array' => $builderContractTypes->toArray()
                ],
                'book_users' => [
                    'select_html' => $builderUsers->toHtml(),
                    'select_array' => $builderUsers->toArray()
                ]
            ]);
 
             $response_array['status'] = 'success';
 
             // Итоговые манипуляции
             $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
 
             // Возвращаем ответ
             return $response;
        }

        /*
            Рендер модалки "Редактирование договора"
        */
        public function render_fmodal_contract_update($twig_element, Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');

            // Получаем параметры POST и сразу записываем их в массив с ответом
            $params = $response_array['request_params'] = $request->request->all();
            $contract = OrgContracts::where('id', '=', $params['id'])->first();
            $response_array['client'] = Organizations::find($contract['organization_id']);
            $response_array['users_db'] = Users::all();

            $builderContractTypes = new ComponentSelectBuilder([
                'db_field_name' => 'doc_type_id',
                'required' => true,
                'val' => $contract->doc_type_id,
                'not_selected_text' => 'Выберите договор'
            ]);
            foreach (OrgContracts::BOOK_TYPES as $idType => $nameType) {
                $builderContractTypes->addIdItem($idType)->addTextItem($nameType)->saveItem();
            }

            $builderUsers = new ComponentSelectBuilder([
                'db_field_name' => 'responsible_user_id',
                'required' => true,
                'val' => $contract->responsible_user_id,
                'not_selected_text' => 'Выберите ответственного'
            ]);
            foreach ($response_array['users_db'] as $user) {
                $builderUsers->addIdItem($user->id)->addTextItem($user->name)->saveItem();
            }
 
            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $response_array['client'],
                'contract' => $contract,
                'contract_types' => [
                    'select_html' => $builderContractTypes->toHtml(),
                    'select_array' => $builderContractTypes->toArray()
                ],
                'book_users' => [
                    'select_html' => $builderUsers->toHtml(),
                    'select_array' => $builderUsers->toArray()
                ]
            ]);
 
             $response_array['status'] = 'success';
 
             // Итоговые манипуляции
             $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
 
             // Возвращаем ответ
             return $response;
        }

        /*
            Рендер модалки "Новый счет"
        */
        public function render_fmodal_new_bill($twig_element, Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');

            // Получаем параметры POST и сразу записываем их в массив с ответом
            $params = $response_array['request_params'] = $request->request->all();
            $client = Organizations::find($params['client_id']);

            // Статусы
            $builderBillsTypes = new ComponentSelectBuilder([
                'db_field_name' => 'status',
                'required' => true,
                'not_selected_text' => 'Статус'
            ]);
            foreach (OrgBills::getArrayStatuses() as $idStatus => $nameStatus) {
                $builderBillsTypes->addIdItem($idStatus)->addTextItem($nameStatus)->saveItem();
            }

            // OrgContracts
            $builderContracts = new ComponentSelectBuilder([
                'db_field_name' => 'contract_id',
                'required' => true,
                'not_selected_text' => 'Выберите договор для создания счета'
            ]);

            foreach(OrgContracts::where('organization_id', '=', $client->id)->get() as $contract) {
                $builderContracts->addIdItem($contract->id)->addTextItem('Договор №: ' . $contract->contract_num)->saveItem();
            }


            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $client,
                'statuses' => [
                    'select_html' => $builderBillsTypes->toHtml(),
                    'select_array' => $builderBillsTypes->toArray()
                ],
                'contracts' => [
                    'select_html' => $builderContracts->toHtml(),
                    'select_array' => $builderContracts->toArray()
                ]
            ]);
 
             $response_array['status'] = 'success';
 
             // Итоговые манипуляции
             $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
 
             // Возвращаем ответ
             return $response;
        }

        /*
            Рендер модалки "Редактирование счета"
        */
        public function render_fmodal_bill_update($twig_element, Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');

            // Получаем параметры POST и сразу записываем их в массив с ответом
            $params = $response_array['request_params'] = $request->request->all();
            $client = Organizations::find($params['client_id']);
            $bill = OrgBills::find($params['id']);


            // Статусы
            $builderBillsTypes = new ComponentSelectBuilder([
                'db_field_name' => 'status',
                'required' => true,
                'val' => $bill->status,
                'not_selected_text' => 'Статус'
            ]);
            foreach (OrgBills::getArrayStatuses() as $idStatus => $nameStatus) {
                $builderBillsTypes->addIdItem($idStatus)->addTextItem($nameStatus)->saveItem();
            }

            // OrgContracts
            $builderContracts = new ComponentSelectBuilder([
                'db_field_name' => 'contract_id',
                'required' => true,
                'val' => $bill->contract_id,
                'not_selected_text' => 'Выберите договор для создания счета'
            ]);
            foreach(OrgContracts::where('organization_id', '=', $client->id)->get() as $contract) {
                $builderContracts->addIdItem($contract->id)->addTextItem('Договор №: ' . $contract->contract_num)->saveItem();
            }


            // Рендерим
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'request_params' => $response_array['request_params'],
                'client' => $client,
                'bill' => $bill,
                'statuses' => [
                    'select_html' => $builderBillsTypes->toHtml(),
                    'select_array' => $builderBillsTypes->toArray()
                ],
                'contracts' => [
                    'select_html' => $builderContracts->toHtml(),
                    'select_array' => $builderContracts->toArray()
                ]
            ]);
 
             $response_array['status'] = 'success';
 
             // Итоговые манипуляции
             $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
 
             // Возвращаем ответ
             return $response;
        }
    /*--- End Модалка fmodal */
}