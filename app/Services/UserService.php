<?php

namespace WWCrm\Services;

// Сервис контейнер DI
use WWCrm\ServiceContainer;

// Пользователи
use WWCrm\Models\Users;

// Компоненты
use WWCrm\Services\ComponentSelectBuilder;

final class UserService {

    protected $WWCrmService;
    protected $session;
    protected $paths;
    protected $imageManager;

    public function __construct() {
        $this->WWCrmService = ServiceContainer::getInstance(); // Получаем контейнер
        $this->session = $this->WWCrmService->get('SymfonySession'); // Получаем сессии
        $this->paths = $this->WWCrmService->get('paths');
        $this->imageManager = $this->WWCrmService->get('ImageManager');
    }

    /*
        Сохранение аватарки пользователя

        Обязательно возвращать имя файла при успешном сохранении!
    */
    public function saveUserAvatarFromFile(array $file_array) : string|false {
        if (!$file_array) {
            return false;
        }

        // Путь до хранения аватарок
        $save_dir = $this->paths['users_avatars'];

        if (is_dir($save_dir)) {
            $old_file_path = $file_array['tmp_name'];
            $file_name = time() . '.jpg';
            $new_file_path = $save_dir . '/' . $file_name;

            $this->imageManager->read($old_file_path)->cover(300, 300, 'center')->toJpg()->save($old_file_path);

            if (move_uploaded_file($old_file_path, $new_file_path)) {
                return $file_name;
            } else {
                return false;
            }
        }

        return false;
    }


    /*
        Поиск пользователя по имейлу
    */
    public function findUserByEmail(string $email) : Users|false {
        $user = Users::where('email', '=', $email)->first();

        if (!empty($user)) {
            return $user;
        } else {
            return false;
        }
    }

    /*
        Получить html отрендеренный компонент со списком пользователей
    */
    // public function getComponentSelect(string $component_input_name = null, bool $required = null) : false|string {

    //     if (empty($component_input_name) || empty($required)) {
    //         return false;
    //     }

    //     $componentBuilder = new ComponentSelectBuilder($component_input_name, $required);

    //     foreach (Users::all() as $user) {
    //         $componentBuilder->addIdItem($user->id)->addTextItem($user->name)->saveItem();
    //     }

    //     return $componentBuilder->toArray();


    // }
}