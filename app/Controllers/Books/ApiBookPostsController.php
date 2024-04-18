<?php

namespace WWCrm\Controllers\Books;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*
    Билдер для компонента селекта
*/
use WWCrm\Services\ComponentSelectBuilder;

/*
    Модели - 1 модель работает с 1 таблицей в БД
    Расширяют класс Model от Laravel
*/
use WWCrm\Models\BookPosts;
use WWCrm\Models\BookDepartments;

class ApiBookPostsController extends \WWCrm\Controllers\MainController {

    /*
        Удаление должности
    */
    public function delete(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        $countPosts = BookPosts::all()->count();

        if ($countPosts === 1) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Осталась всего 1 должность. Ее нельзя удалить';
        } else {
            if(BookPosts::find($response_array['request_params']['id'])->delete()) {
                $response_array['status'] = 'success';
                $response_array['message'] = 'Успешное удаление должности';
            } else {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Не удалось удалить должность';
            }
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Создание должности
    */
    public function create(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');


        try {
            BookPosts::create($response_array['request_params']);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное добавление должности';
        } catch (\Illuminate\Database\QueryException $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Не удалось создать должность';
            $response_array['exception_message'] = $e->getMessage();
            
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }


        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /*
        Обновление должности
    */
    public function update(Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $response->headers->set('Content-Type', 'application/json');

        try {
            BookPosts::find($response_array['request_params']['id'])->update($response_array['request_params']);

            $response_array['status'] = 'success';
            $response_array['message'] = 'Успешное обновление должности';
        } catch (\Illuminate\Database\QueryException $e) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Не удалось обновить должность';
            $response_array['exception_message'] = $e->getMessage();
            
            $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
            return $response;
        }

        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    // Выступает в качестве распределителя
    public function distributor($twig_element, Request $request, Response $response) {
        $twig_element = $twig_element . '.twig';

        if ($twig_element == 'main-table.twig') {
            return $this->render_main_table($twig_element, $request, $response);
        } else if($twig_element == 'fmodal-book-new-post.twig') {
            return $this->render_fmodal_book_new_post($twig_element, $request, $response);
        } else if($twig_element == 'fmodal-book-post-update.twig') {
            return $this->render_fmodal_book_post_update($twig_element, $request, $response);
        } else {
            return 'Распределитель рендер запросов. Возврат пустого ответа';
        }
    }

    /*
        Рендер главной таблицы main-table.twig
    */
    public function render_main_table($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        
        if (!empty($response_array['request_params']['control_panel_condition'])) {
            $posts = BookPosts::where('name', 'like', '%' . $response_array['request_params']['control_panel_condition'] . '%')->get();
        } else {
            $posts = BookPosts::all();
        }

        $response_array['render_response_html'] = $this->view->render('books/posts/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'posts' => $posts
        ]);

        $response_array['status'] = 'success';
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Рендер fmodal-book-new-post.twig
    */
    public function render_fmodal_book_new_post($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();

        $DepartmentsSelect = new ComponentSelectBuilder('department_id', true);
        $DepartmentsSelect->setDefaultText('Не выбрано'); // Дефолтный текст

        foreach(BookDepartments::all() as $depKey => $dep) { // Добавляем выгруженные элементы селект
            $DepartmentsSelect->addIdItem($dep->id)->addTextItem($dep->name)->saveItem();
        }

        $response_array['render_response_html'] = $this->view->render('books/posts/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'departments_select_prop' => $DepartmentsSelect->toArray()
        ]);

        $response_array['status'] = 'success';
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /*
        Рендер fmodal-book-post-update.twig
    */
    public function render_fmodal_book_post_update($twig_element, Request $request, Response $response) {
        // Получаем параметры POST и сразу записываем их в массив с ответом
        $response_array['request_params'] = $request->request->all();
        $post = BookPosts::find($response_array['request_params']['id']);

        $DepartmentsSelect = new ComponentSelectBuilder('department_id', true);
        $DepartmentsSelect->setDefaultText('Не выбрано'); // Дефолтный текст
        $DepartmentsSelect->setVal($post->department_id); // Дефолтный текст
        foreach(BookDepartments::all() as $depKey => $dep) { // Добавляем выгруженные элементы селект
            $DepartmentsSelect->addIdItem($dep->id)->addTextItem($dep->name)->saveItem();
        }

        $response_array['render_response_html'] = $this->view->render('books/posts/render/' . $twig_element, [
            'request_params' => $response_array['request_params'],
            'post' => $post,
            'departments_select_prop' => $DepartmentsSelect->toArray()
        ]);

        $response_array['status'] = 'success';
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($response_array, JSON_UNESCAPED_UNICODE));

        return $response;
    }

}