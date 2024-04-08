<?php

namespace WWCrm\Controllers\Auth;

/* 
    Компоненты Symfony запрос и ответ
    https://symfony.ru/doc/current/components/http_foundation.html
*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Пользователи
use WWCrm\Models\Users;


class ApiAuthController extends \WWCrm\Controllers\MainController {
    /*
        Авторизация
    */
    public function sign_in(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        $response->headers->set('Content-Type', 'application/json');

        $login = $response_array['request_params']['login'];
        $password = $response_array['request_params']['password'];
        $is_remember = $response_array['request_params']['is_remember'];

        if (empty($login)) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили логин!';
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }

        if (empty($password)) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили пароль!';
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }
        
        if (!empty($login) && !empty($password)) {

            // Поиск юзера в бд и его авторизация
            $user_by_login = Users::where(['tel' => $login])->first();

            if (empty($user_by_login)) {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Пользователь с таким логином - не найден!';
                $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

                return $response;
            } else {

                if(password_verify($password, $user_by_login->password)) {
                    
                    if ($this->WWCurrentUser->login_by_user_id($user_by_login->id)) {
                        $response_array['status'] = 'success';
                        $response_array['message'] = 'Авторизация прошла успешно';
                        $response_array['user_obj'] = $this->WWCurrentUser->getUserObject();
                        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
                        return $response;
                    }
                } else {
                    $response_array['status'] = 'error';
                    $response_array['message'] = 'Вы указали не верный пароль';
                    $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
                    return $response;
                }
            }

        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили логин и пароль!';
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }
    }

    /*
        Выход из системы
    */
    public function logout(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');
        
        if($this->WWCurrentUser->logout()) {
            $response_array['status'] = 'success';
            $response_array['message'] = 'Вы успешно вышли из системы';
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Не удалось выйти из системы. Что-то пошло не так...';
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }
    }
}