<?php

namespace WWCrm\Services\User;

// Главный сервис
use WWCrm\Services\MainService;


// Пользователи
use WWCrm\Models\Users;

// Компоненты
use WWCrm\Services\ComponentSelectBuilder;

// Dto
use WWCrm\Dto\UserDto;

// Класс исключений
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

        /*
            Проверяем на заполненность имени
        */
        if(empty($dto->getName())) {
            throw new Exception('Вы должны заполнить имя');
        }

        /*
            Проверка на Email
        */
        if ($this->findUserByEmail($dto->getEmail())) {
            throw new Exception('Пользователь с таким Email уже существует');
        }

        /*
            Валидность Email
        */
        if (!$this->utils->isValidEmail($dto->getEmail())) {
            throw new Exception('Email введен не верно!');
        }

        if (empty($dto->getPassword())) {
            throw new Exception('Вы не создали пароль для пользователя!');
        }

        /*
            Сохраняем новое фото, если оно есть
        */
        if ($dto->getAvatartFileRequest()) {
            $file_name = $this->saveUserAvatarFromFile($dto->getAvatartFileRequest());
            $dto->setAvatarFileName($file_name);
        }

        /*
            Создание пользователя
        */
        try {
            $pass = password_hash($dto->getPassword(), PASSWORD_DEFAULT);
            $user_array = $dto->toArray();
            $user_array['password'] = $pass;

            return Users::create($user_array);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
        Обновление пользователя
    */
    public function updateUser(UserDto $dto) : bool {
        $user = Users::find($dto->getId());

        if ($user) {

            /*
                Валидность Email
            */
            if (!$this->utils->isValidEmail($dto->getEmail())) {
                throw new Exception('Email введен не верно!');
            }

            /*
                Возвращаем ошибку, если юзер с таким пользователем уже есть
            */
            if($this->findUserByEmail($dto->getEmail()) && $this->findUserByEmail($dto->getEmail())['email'] != $dto->getEmail()) {
                throw new Exception('Пользователь с таким Email уже существует');
            }

            /*
                Проверяем валидность ФИО
            */
            if(!$this->utils->isValidFio(($dto->getName())) || !$this->utils->isValidFio($dto->getSurname()) || !$this->utils->isValidFio($dto->getPatronymic())) {
                throw new Exception('ФИО должно содержать только буквы');
            }

            /*
                Проверяем на заполненность имени
            */
            if(empty($dto->getName())) {
                throw new Exception('Вы должны заполнить имя');
            }

            /*
                Сохраняем новое фото, если оно есть
            */
            if ($dto->getAvatartFileRequest()) {
                $file_name = $this->saveUserAvatarFromFile($dto->getAvatartFileRequest());
                $dto->setAvatarFileName($file_name);
            }

            /*
                Если есть новое фото, то удаляем старое
            */
            if($dto->getAvatarFileName()) {
                $old_file_name = $user->avatar_file_name;
                $directory_file = $this->paths['users_avatars'] . '/' . $old_file_name;

                if (file_exists($directory_file) && isset($old_file_name)) {
                    unlink($directory_file);
                }
            }

            if ($user->update($dto->toArray())) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*
        Смена статуса пользователя
    */
    public function chengeStatusUser(UserDto $dto) : bool {
        $user = Users::find($dto->getId());

        if ($user->update($dto->toArray())) {
            return true;
        } else {
            return false;
        }
    }


}