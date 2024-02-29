<?php

namespace WWCrm\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use WWCrm\Models\Organizations;

class ApiClientsController extends \WWCrm\Controllers\MainController {
    
    /*
        Создание организации
    */
    public function create(Request $request, Response $response) {

        // Получаем параметры
        $params = $request->request->all();

        // Создаем пользователя
        $client = Organizations::create($params);

        $response_array['db_fields'] = Organizations::find($client->id);
        $response_array['status'] = 'success';
        $response_array['message'] = 'Клиент создан';
        $response_array['request_params'] = $params;

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    // Выступает в качестве распределителя
    public function distributor($twig_element, Request $request, Response $response) {
        if ($twig_element == 'main-table') {
            return $this->render_main_table($twig_element, $request, $response);
        }
    }





    public function render_main_table($twig_element, Request $request, Response $response) { // Рендер twig элементов
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $twig_element = $twig_element . '.twig';

        if (!empty($twig_element)) { // Если есть рендер элемент

            // Start Данные для пагинации
            $current_page = !empty($response_array['request_params']['current_page']) ? (int) $response_array['request_params']['current_page'] : 1; // Текущая страница
            $per_page = 10; // Отображаемое количество на странице
            $offset = ($current_page - 1) * $per_page; // Offset для sql (пропуск выгрузки)
            $offset_next = $current_page * $per_page; // Offset для sql (пропуск для следующей страницы)

            // Говорим, что будем пропускать кол-во записей и выводить определенное
            // Начальное построение запроса
            $queryBuild = Organizations::offset($offset)->limit($per_page);
            $queryBuildNext = Organizations::offset($offset_next)->limit($per_page);
            
            if ($condition = $response_array['request_params']['control_panel_condition']) {
                $queryBuild->where('inn', 'like', '%' . $condition['name'] . '%')
                            ->orWhere('name', 'like', '%' . $condition['name'] . '%');
                $queryBuildNext->where('inn', 'like', '%' . $condition['name'] . '%')
                                ->orWhere('name', 'like', '%' . $condition['name'] . '%');
            }

            $response_array['pagination']['offset'] = $offset;
            $response_array['pagination']['per_page'] = $per_page;
            $response_array['pagination']['current_page'] = $current_page;
            $response_array['pagination']['next_page'] = $current_page + 1;
            $response_array['pagination']['prev_page'] = $current_page - 1;
            $response_array['pagination']['has_next_page'] = count($queryBuildNext->get()) ? true : false; // Есть ли следующая страница
            // End Данные для пагинации


            $response_array['status'] = 'success';
            $response_array['message'] = 'Элемент успешно отрендерился';
            $response_array['table_rows'] = $queryBuild->get();
            
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $twig_element, [
                'table_rows' => $response_array['table_rows'],
                'pagination' => $response_array['pagination'],
                'request_params' => $response_array['request_params']
            ]);

        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Twig элемент не найден в POST запросе. Проверьте отправляемые данные';
        }


        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }
    

}