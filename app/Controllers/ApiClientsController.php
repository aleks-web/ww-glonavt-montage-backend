<?php

namespace WWCrm\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Pagination\Paginator;

use WWCrm\Models\Clients;

class ApiClientsController extends \WWCrm\Controllers\MainController {

    public function create(Request $request, Response $response) {

        // Получаем параметры
        $params = $request->request->all();

        // Создаем пользователя
        $client = Clients::create($params);

        $response_array['db_fields'] = Clients::find($client->id);
        $response_array['status'] = 'success';
        $response_array['message'] = 'Клиент создан';
        $response_array['request_params'] = $params;

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }


    public function render(Request $request, Response $response) { // Рендер twig элементов
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();


        if (!empty($response_array['request_params']['twig_element'])) { // Если есть рендер элемент

            // Start Данные для пагинации
            $current_page = !empty($response_array['request_params']['current_page']) ? (int) $response_array['request_params']['current_page'] : 1; // Текущая страница
            $per_page = 10; // Отображаемое количество на странице
            $offset = ($current_page - 1) * $per_page; // Offset для sql (пропуск выгрузки)
            $offset_next = $current_page * $per_page; // Offset для sql (пропуск выгрузки)
            $count_clients = Clients::count(); // Количество элементов в таблице
            $clients = Clients::offset($offset)->limit($per_page)->get();
            $clients_next = Clients::offset($offset_next)->limit($per_page)->get();

            $response_array['pagination']['items_count'] = $count_clients;
            $response_array['pagination']['offset'] = $offset;
            $response_array['pagination']['per_page'] = $per_page;
            $response_array['pagination']['current_page'] = $current_page;
            $response_array['pagination']['next_page'] = $current_page + 1;
            $response_array['pagination']['prev_page'] = $current_page - 1;
            $response_array['pagination']['has_next_page'] = count($clients_next) ? true : false; // Есть ли следующая страница
            // End Данные для пагинации


            $response_array['status'] = 'success';
            $response_array['message'] = 'Элемент успешно отрендерился';
            $response_array['table_rows'] = $clients;
            
            $response_array['render_response_html'] = $this->view->render('modules/clients/render/' . $response_array['request_params']['twig_element'], [
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