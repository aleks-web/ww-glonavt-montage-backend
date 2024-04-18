<?php

namespace WWCrm\Services;

use WWCrm\ServiceContainer;

// Пользователи
use WWCrm\Models\Users;

use WWCrm\Models\BookPosts;
use WWCrm\Models\BookDepartments;

final class CurrentUser {

    protected $WWCrmService;
    protected $session;

    public function __construct() {
        $this->WWCrmService = ServiceContainer::getInstance(); // Получаем контейнер
        $this->session = $this->WWCrmService->get('SymfonySession'); // Получаем сессии
    }

    /*
        Метод проверки на авторизованность пользователя
    */
    public function isAuterisation() : bool {
        $user_id = $this->session->get('user_id');

        if (!$user_id) {
            return false;
        }

        return true;
    }

    /*
        Метод возвращает объект текущего пользователя
    */
    public function getUserObject() : Object | false {
        if($this->isAuterisation()) {
            $user_id = $this->session->get('user_id');

            $user = Users::find($user_id)->first();
            $post = BookPosts::find($user->post_id);
            $department = BookDepartments::find($post->department_id);
            $user->post = $post;
            $user->department = $department;

            return $user;
        }

        return false;
    }

    /*
        Возвращает true при удачном разлогировании
    */
    public function logout() : bool {
        $this->session->set('user_id', null);

        if ($this->session->get('user_id')) {
            return false;
        } else {
            return true;
        }
    }

    /*
        Логинит юзера по id. Возвращает либо true либо false
    */
    public function login_by_user_id($user_id = null) : bool {
        $this->session->set('user_id', $user_id);

        if ($this->session->get('user_id')) {
            return true;
        } else {
            return false;
        }
    }

}