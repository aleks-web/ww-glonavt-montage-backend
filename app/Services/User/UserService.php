<?php

namespace WWCrm\Services\User;

use WWCrm\Services\MainService;


// Пользователи
use WWCrm\Models\Users;

// Компоненты
use WWCrm\Services\ComponentSelectBuilder;

// Dto
use WWCrm\Dto\UserDto;

use Exception;

final class UserService extends MainService {

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
       Создание пользователя 
    */
    public function createUser(UserDto $dto) : Users {

        // Проверка на Email
        if ($this->findUserByEmail($dto->getEmail())) {
            throw new Exception('Пользователь с таким Email уже существует');
        }

        /*
            Валидность Email
        */
        if (!$this->utils->isValidEmail($dto->getEmail())) {
            throw new Exception('Email введен не верно!');
        }

        return Users::create($dto->toArray());
    }
}