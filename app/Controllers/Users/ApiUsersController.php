<?php

namespace WWCrm\Controllers\Users;

/* 
    Компоненты Symfony запрос и ответ
    https://symfony.ru/doc/current/components/http_foundation.html
*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\FileBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
            $this->userService->createUser(new UserDto($params));

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



        // try {
        //     // $user = Users::create($response_array['request_params']);

        //     $file_name = $_FILES['avatar'] ? $this->userService->saveUserAvatarFromFile($_FILES['avatar']) : false;

        //     if ($file_name) {
        //         $user->avatar_file_name = $file_name;
        //         $user->save();
        //     }

        //     if ($user && $response_array['request_params']['is_send_password']) {
        //         $user->password = $originalPass;

        //         $serverData = $request->server->all();
        //         $mail = $this->view->render('mail/create-account.twig', [
        //             'user' => $user,
        //             'url' => $serverData['REQUEST_SCHEME'] . '://' . $serverData['HTTP_HOST'],
        //             'domain' => $serverData['HTTP_HOST'],
        //             'logo_url' => $serverData['REQUEST_SCHEME'] . '://' . $serverData['HTTP_HOST'] . '/assets/img/glonavt_logo.svg'
        //         ]);

        //         mail($user->email, 'glonavt.ru - создание аккаунта', $mail, "From: no-reply@crmdev.glonavt.ru\r\n"."Content-type: text/html; charset=utf-8\r\n"."X-Mailer: PHP mail script");
        //     }

        //     $response_array['status'] = 'success';
        //     $response_array['message'] = 'Успешное создание пользователя';
        // } catch (\Illuminate\Database\QueryException $e) {
        //     $response_array['status'] = 'error';

        //     $response_array['message'] = 'Не удалось создать пользователя';
        //     $response_array['exception_message'] = $e->getMessage();
            
        //     $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        //     return $response;
        // }
    }

    /*
        Обновление пользователя
    */
    public function update(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        $user = Users::find($response_array['request_params']['id']);

        $response_array['request_params']['tel'] = $this->utils->formatTel($response_array['request_params']['tel']);
        $response_array['request_params']['post_id'] = empty($response_array['request_params']['post_id']) ? null : $response_array['request_params']['post_id'];


        /*
            Проверяем валидность email
        */
        if (empty($params['email']) || !$this->utils->isValidEmail($params['email'])) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Не коррекртый Email адрес';

            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }


        /*
            Возвращаем ошибку, если юзер с таким пользователем уже есть
        */
        if($this->userService->findUserByEmail($response_array['request_params']['email']) && $this->userService->findUserByEmail($response_array['request_params']['email'])['email'] != $user->email) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Пользователь с таким Email уже существует';

            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }

        /*
            Проверяем валидность ФИО
        */
        if(!$this->utils->isValidFio($params['name']) || !$this->utils->isValidFio($params['surname']) || !$this->utils->isValidFio($params['patronymic'])) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'ФИО должно содержать только буквы';

            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }

        // Обновляем юзера
        $user->update($response_array['request_params']);

        $response_array['status'] = 'success';
        $response_array['message'] = 'Данные пользователя успешно обновлены';
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
        } else if ($twig_element == 'modal-current-user.twig') {
            return $this->render_modal_current_user($twig_element, $request, $response);
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
        $response_array['request_params'] = $request->request->all();
        $response_array['users'] = Users::all();

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
            'paths' => $this->paths
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


        $PostsSelect = new ComponentSelectBuilder('post_id', false);
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

        $PostsSelect = new ComponentSelectBuilder('post_id', false);
        $PostsSelect->setVal($response_array['user']->post_id);
        $PostsSelect->setDefaultText('Должность не выбрана');
        foreach($response_array['posts'] as $post) { // Добавляем выгруженные элементы селект
            $PostsSelect->addIdItem($post->id)->addTextItem($post->name . ' (' . $post->department->name . ')')->saveItem();
        }
        $response_array['twig_components_data']['posts'] = $PostsSelect->toArray();

        $response_array['render_response_html'] = $this->view->render('modules/users/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'user' => $response_array['user'],
            'paths' => $this->paths,
            'twig_components_data' => $response_array['twig_components_data']
        ]);
 
         $response_array['status'] = 'success';
 
         $response->headers->set('Content-Type', 'application/json');
         $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
 
         return $response;
    }

    /*
        Рендер модального окна "Редактирование собственной карточки пользователя"
        Редактирование аккаунта
    */
    public function render_modal_current_user($twig_element, Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();

        $response_array['render_response_html'] = $this->view->render('modals/render/' . $twig_element, [
            'request_params' => $params,
            'user' => Users::find($params['id'])
        ]);

        $response_array['status'] = 'success';
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }
}