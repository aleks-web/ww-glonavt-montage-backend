<?php

namespace WWCrm\Controllers\Users;

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
use WWCrm\Models\Users;
use WWCrm\Models\BookPosts;
use WWCrm\Models\BookDepartments;

// Dto
use WWCrm\Dto\UserDto;

use Exception;

class ApiUsersController extends \WWCrm\Controllers\MainController {

    /*
        Создание пользователя
    */
    public function create(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');
        
        /*
            Создание пользователя
        */
        try {
            $userDto = new UserDto($params);

            // Если загрузили фото
            if ($_FILES['avatar']) {
                $userDto->setAvatartFileRequest($_FILES['avatar']);
            }

            $user = $this->userService->createUser($userDto);

            if ($user && $params['is_send_password']) {
                $user->password = $userDto->getPassword();

                $serverData = $request->server->all();
                $mail = $this->view->render('mail/create-account.twig', [
                    'user' => $user,
                    'url' => $serverData['REQUEST_SCHEME'] . '://' . $serverData['HTTP_HOST'],
                    'domain' => $serverData['HTTP_HOST'],
                    'logo_url' => $serverData['REQUEST_SCHEME'] . '://' . $serverData['HTTP_HOST'] . '/assets/img/glonavt_logo.svg'
                ]);

                mail($user->email, 'glonavt.ru - создание аккаунта', $mail, "From: no-reply@crmdev.glonavt.ru\r\n"."Content-type: text/html; charset=utf-8\r\n"."X-Mailer: PHP mail script");
            }

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное создание пользоватееля';
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        } catch (Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Не удалось создать пользователя';
            $response_array['exception_message'] = $e->getMessage();
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }

    }

    /*
        Обновление пользователя
    */
    public function update(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        $userDto = new UserDto($params);
        
        // Если загрузили фото
        if ($_FILES['avatar']) {
            $userDto->setAvatartFileRequest($_FILES['avatar']);
        }

        try {
            if ($params['event_name'] == 'chenge_status') {
                $user = $this->userService->chengeStatusUser($userDto);
                $response_array['message'] = 'Статус пользователя изменен';
            } else {
                $user = $this->userService->updateUser($userDto);
                $response_array['message'] = 'Успешное обновление данных пользователя';
            }

            $response_array['status'] = 'success';
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        } catch (Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Не удалось обновить данные пользователя';
            $response_array['exception_message'] = $e->getMessage();
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }
    }

    /*
        Выступает в качестве распределителя
    */
    public function distributor($twig_element, Request $request, Response $response) {
        $twig_element = $twig_element . '.twig';

        if ($twig_element == 'main-table.twig') {
            return $this->render_main_table($twig_element, $request, $response);
        } else if ($twig_element == 'modal-user-add.twig') {
            return $this->render_modal_user_add($twig_element, $request, $response);
        } else if ($twig_element == 'modal-user.twig') {
            return $this->render_modal_user($twig_element, $request, $response);
        } else if ($twig_element == 'main-table.twig') {
            return $this->render_main_table($twig_element, $request, $response);
        } else {
            return 'Распределитель рендер запросов. Возврат пустого ответа';
        }
    }

    /*
        Рендер главной таблицы
    */
    public function render_main_table($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        if ($cond = $response_array['request_params']['control_panel_condition']) {
            $response_array['users'] = Users::where('name', 'like', '%' . $cond .  '%')
                                            ->orWhere('surname', 'like', '%' . $cond .  '%')
                                            ->orWhere('patronymic', 'like', '%' . $cond .  '%')
                                            ->orWhere('tel', 'like', '%' . $cond .  '%')
                                            ->orWhere('email', 'like', '%' . $cond .  '%')
                                            ->get();
        } else {
            $response_array['users'] = Users::all();
        }

        foreach ($response_array['users'] as $user) {
            $user->post;
        }

        $response_array['render_response_html'] = $this->view->render('modules/users/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'users' => $response_array['users'],
            'users_named_statuses' => Users::getArrayStatuses(),
            'paths' => $this->paths,
            'current_user' => $this->WWCurrentUser->getUserObject()
        ]);

        $response_array['status'] = 'success';

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Рендер модального окна (добавление нового пользователя)
    */
    public function render_modal_user_add($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response_array['posts'] = BookPosts::all();


        $PostsSelect = new ComponentSelectBuilder(['db_field_name' => 'post_id', 'required' => false]);
        $PostsSelect->setDefaultText('Должность не выбрана');
        foreach($response_array['posts'] as $post) { // Добавляем выгруженные элементы селект
            $PostsSelect->addIdItem($post->id)->addTextItem($post->name . ' (' . $post->department->name . ')')->saveItem();
        }
        $response_array['twig_components_data']['posts'] = $PostsSelect->toArray();

 
        $response_array['render_response_html'] = $this->view->render('modules/users/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'twig_components_data' => $response_array['twig_components_data']
        ]);
 
         $response_array['status'] = 'success';
 
         $response->headers->set('Content-Type', 'application/json');
         $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
 
         return $response;
    }

    /*
        Рендер модального окна (просмотр пользователя)
    */
    public function render_modal_user($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response_array['user'] = Users::find($response_array['request_params']['user_id']);
        $response_array['user']->post->department;
        $response_array['posts'] = BookPosts::all();

        $PostsSelect = new ComponentSelectBuilder(['db_field_name' => 'post_id', 'required' => false]);
        $PostsSelect->setVal($response_array['user']->post_id);
        $PostsSelect->setDefaultText('Должность не выбрана');
        foreach($response_array['posts'] as $post) { // Добавляем выгруженные элементы селект
            $PostsSelect->addIdItem($post->id)->addTextItem($post->name . ' (' . $post->department->name . ')')->saveItem();
        }
        $response_array['twig_components_data']['posts'] = $PostsSelect->toArray();

        $response_array['render_response_html'] = $this->view->render('modules/users/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'user' => $response_array['user'],
            'user_statuses' => Users::getArrayStatusesNamed(),
            'paths' => $this->paths,
            'twig_components_data' => $response_array['twig_components_data']
        ]);
 
         $response_array['status'] = 'success';
 
         $response->headers->set('Content-Type', 'application/json');
         $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
 
         return $response;
    }

}