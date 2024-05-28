<?php

namespace WWCrm\Controllers\DaData;

/* 
    Компоненты Symfony запрос и ответ
    https://symfony.ru/doc/current/components/http_foundation.html
*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ApiDaDataController extends \WWCrm\Controllers\MainController {
    public function check_org_by_inn(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        if ($params['inn']) {
            $dadata = $this->WWCrmService->get('DaData');
            $result = $dadata->findById("party", trim($params['inn']), 1)[0];

            $response_array['status'] = 'success';
            $response_array['dadata_output'] = $result;
            $response_array['message'] = 'Успешное получение данных из сервиса DaData';
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили ИНН';
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    public function check_bank_by_bic(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        if ($params['bic']) {
            $dadata = $this->WWCrmService->get('DaData');
            $result = $dadata->findById("bank", trim($params['bic']), 1)[0];

            $response_array['status'] = 'success';
            $response_array['dadata_output'] = $result;
            $response_array['message'] = 'Успешное получение данных из сервиса DaData';
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Вы не заполнили БИК';
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}