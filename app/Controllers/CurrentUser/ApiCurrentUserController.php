<?php

namespace WWCrm\Controllers\CurrentUser;

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

// Dto
use WWCrm\Dto\UserDto;

use Exception;

class ApiCurrentUserController extends \WWCrm\Controllers\MainController {

    /*
        Обновление пользователя
    */
    public function update(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $params = $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        // Если это не массив, убиваем
        // Издержки компонентов и js. Костылек можно сказать)
        if (gettype($params['avatar']) != 'array') {
            unset($params['avatar']);
        }

        $userDto = new UserDto($params);

        try {
            if ($params['event_name'] == 'chenge_password') {
                $user = $this->userService->chengePasswordUser($userDto);
                $response_array['message'] = 'Ваш пароль успешно изменен';
            } else {
                // Если загрузили фото, кидаем в dto
                if (!empty($_FILES['avatar'])) {
                    $userDto->setAvatarFileRequest($_FILES['avatar']);
                }

                $user = $this->userService->updateUser($userDto);
                $response_array['message'] = 'Вы успешно обновили свои данные';
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
        } else if ($twig_element == 'modal-current-user.twig') {
            return $this->render_modal_current_user($twig_element, $request, $response);
        } else {
            return 'Распределитель рендер запросов ApiCurrentUserController. twig элемент не найден';
        }
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
            'request_params' => $params
        ]);

        $response_array['status'] = 'success';
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }
}