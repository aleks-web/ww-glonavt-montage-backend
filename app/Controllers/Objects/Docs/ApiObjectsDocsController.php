<?php

namespace WWCrm\Controllers\Objects\Docs;

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
use WWCrm\Models\ObjDocs;
use WWCrm\Models\Objects;

// DTO
use WWCrm\Dto\ObjDocDto;


class ApiObjectsDocsController extends \WWCrm\Controllers\MainController {

    /*
        Создание документа для объекта
    */
    public function create(Request $request, Response $response) {
        $response->headers->set('Content-Type', 'application/json');

        // Получаем параметры
        $params = $response_array['request_params'] = $request->request->all();

        $dto = new ObjDocDto($params);

        try {
            $response_array['status'] = 'success';
            $response_array['message'] = 'Документ создан';
        } catch (\Exception $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Документ создать не удалось';
            $response_array['exception_message'] = $e->getMessage();
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}