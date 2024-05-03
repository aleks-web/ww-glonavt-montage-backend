<?php

namespace WWCrm\Services\Object;

// Главный сервис
use WWCrm\Services\MainService;

// Объекты
use WWCrm\Models\Objects;

// Dto
use WWCrm\Dto\ObjectDto;

final class ObjectService extends MainService {
    /*
        Создание объекта
    */
    public function createObject(ObjectDto $dto) : Objects {
        try {
            // Проверяем валидность года
            if ($dto->getYear() != null && $dto->getYear() != '') {
                if (!$this->utils->isValidYear($dto->getYear())) {
                    throw new \Exception("Не валидный год");
                }
            }

            /*
                Добавляем фото объекта в dto. Название файла
            */
            if ($dto->getObjectPhotoRequest()) {
                $file_name = $this->saveObjectPhotoFromFile($dto->getObjectPhotoRequest());
                $dto->setObjectPhotoFileName($file_name);
            }

            $dto->setUserAddId($this->currentUser->getId());

            // Создаем объект
            return Objects::create($dto->toArray());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Обновляем объект
    */
    public function updateObject(ObjectDto $dto) : bool {
        // Проверяем валидность года
        if (!$this->utils->isValidYear($dto->getYear())) {
            throw new \Exception("Не валидная дата");
        }

        // Обновляем
        try {
            return Objects::find($dto->getId())->update($dto->toArray());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function saveObjectPhotoFromFile(array $fileRequest) : string|false {
        if (!$fileRequest) {
            return false;
        }

        // Путь до хранения фоток объектов
        $save_dir = $this->paths['fs']['object_photos'];

        if (is_dir($save_dir)) {
            $old_file_path = $fileRequest['tmp_name'];
            $file_name = time() . '.jpg';
            $new_file_path = $save_dir . '/' . $file_name;

            $this->imageManager->read($old_file_path)->cover(800, 800, 'center')->toJpg()->save($old_file_path);

            if (move_uploaded_file($old_file_path, $new_file_path)) {
                return $file_name;
            } else {
                return false;
            }
        }

        return false;
    }
}