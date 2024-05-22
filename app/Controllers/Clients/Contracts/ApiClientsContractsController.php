<?php

namespace WWCrm\Controllers\Clients\Contracts;

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
use WWCrm\Models\OrgContracts;

// Dto
use WWCrm\Dto\OrgContractDto;



class ApiClientsContractsController extends \WWCrm\Controllers\MainController {
    /*
        Создание нового договора
    */
    public function create(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();
        $response_array['file'] = $_FILES['contract_file'];

        try {
            $dto = new OrgContractDto($params);

            if ($_FILES['contract_file']) {
                $dto->setContractFileRequest($_FILES['contract_file']);
            }

            $this->orgContractService->createContract($dto);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное создание договора';
        } catch (\Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Неудачное создание договора';
            $response_array['exception_message'] =  $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Удаление нового договора
    */
    public function delete(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        try {
            $dto = new OrgContractDto($params);

            $this->orgContractService->deleteContract($dto->getId());

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное удаление договора';
        } catch (\Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Неудачное удаление договора';
            $response_array['exception_message'] =  $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Реализовать
        Обновление договора
    */
    public function update(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        $response_array['file'] = $_FILES['contract_file'];

        try {
            $dto = new OrgContractDto($params);

            if ($_FILES['contract_file']) {
                $dto->setContractFileRequest($_FILES['contract_file']);
            }

            $this->orgContractService->updateContract($dto);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное обновление договора';
        } catch (\Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Неудачное обновление договора';
            $response_array['exception_message'] =  $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }
}