<?php

namespace WWCrm\Controllers\Auth;

/* 
    Компоненты Symfony запрос и ответ
    https://symfony.ru/doc/current/components/http_foundation.html
*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Cookie;

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
            $user_by_login = Users::where(['email' => $login])->first();

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

                        $response->headers->setCookie(Cookie::create('is_remember', $is_remember)); // Устанавливаем куку
                        $response->headers->setCookie(Cookie::create('sign_in_timestamp', time())); // Устанавливаем куку

                        return $response;
                    }
                } else {
                    $response_array['status'] = 'error';
                    $response_array['message'] = 'Вы указали не верный пароль';
                    $response->headers->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
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

            // Удаляем куки
            $response->headers->setCookie(Cookie::create('is_remember', null));
            $response->headers->setCookie(Cookie::create('sign_in_timestamp', null));

            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Не удалось выйти из системы. Что-то пошло не так...';
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

            return $response;
        }
    }

    /*
        Восстановление пароля
    */
    public function recovery(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        $response_array['request_params'] = $request->request->all();

        $email = $response_array['request_params']['email'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($user = Users::where('email', '=', $email)->first())) {
            $response_array['status'] = 'success';
            $response_array['message'] = $user->name . ', на ваш Email выслан новый пароль';
            $response_array['user']['name'] = $user->name;

            // Тут код генерации пароля и его записи в бд
            $new_pass = mt_rand();
            $new_pass_db = password_hash($new_pass, PASSWORD_DEFAULT);

            $user->password = $new_pass_db;

            $user->save();

            $serverData = $request->server->all();
            $mail = $this->view->render('mail/recovery-password.twig', [
                'password' => $new_pass,
                'username' => $user->name,
                'url' => $serverData['REQUEST_SCHEME'] . '://' . $serverData['HTTP_HOST'],
                'domain' => $serverData['HTTP_HOST'],
                'logo_url' => $serverData['REQUEST_SCHEME'] . '://' . $serverData['HTTP_HOST'] . '/assets/img/glonavt_logo.svg'
            ]);

            mail($email, 'glonavt.ru - восстановление пароля', $mail, "From: no-reply@crmdev.glonavt.ru\r\n"."Content-type: text/html; charset=utf-8\r\n"."X-Mailer: PHP mail script");
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Такого Email адреса не существует. Либо он введен не верно!';
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}