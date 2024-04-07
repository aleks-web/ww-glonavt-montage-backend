<?php

namespace WWCrm\Controllers\Auth;

/* 
    Компоненты Symfony запрос и ответ
    https://symfony.ru/doc/current/components/http_foundation.html
*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ApiAuthController extends \WWCrm\Controllers\MainController {
    /*
        Авторизация | ДОДЕЛАТЬ!
    */
    public function sign_in(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        $login = $response_array['request_params']['login'];
        $password = $response_array['request_params']['password'];
        $is_remember = $response_array['request_params']['is_remember'];

        if (empty($login)) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили логин!';
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }

        if (empty($password)) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили пароль!';
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }
        
        if (!empty($login) && !empty($password)) {

            // Тут код поиска юзера в бд и его авторизация
            $this->session->set('user_id', '1');

            $response_array['status'] = 'success';
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;

        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили логин и пароль!';
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }
    }

}