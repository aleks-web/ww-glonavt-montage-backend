<?php

namespace WWCrm\Controllers\Clients\Bills;

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

// Dto
use WWCrm\Dto\OrgBillDto;



class ApiClientsBillsController extends \WWCrm\Controllers\MainController {
    /*
        Создание нового счета
    */
    public function create(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        try {
            $dto = new OrgBillDto($params);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное создание счета';
        } catch (\Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Неудачное создание счета';
            $response_array['exception_message'] =  $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Удаление счета
    */
    public function delete(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        try {
            $dto = new OrgBillDto($params);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное удаление счета';
        } catch (\Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Неудачное удаление счета';
            $response_array['exception_message'] =  $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Обновление счета
    */
    public function update(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        try {
            $dto = new OrgBillDto($params);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное удаление счета';
        } catch (\Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Неудачное удаление счета';
            $response_array['exception_message'] =  $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }
}