<?php

namespace WWCrm\Services\Object;

// Главный сервис
use WWCrm\Services\MainService;

// Объекты
use WWCrm\Models\Objects;

// Dto
use WWCrm\Dto\ObjectDto;

// События
use WWCrm\Others\Events\Objects\Create as CreateEvent;
use WWCrm\Others\Events\Objects\AfterUpdate as AfterUpdateEvent; // До после сохранения объекта
use WWCrm\Others\Events\Objects\BeforeUpdate as BeforeUpdateEvent; // До того как сохранить объект

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
            $obj = Objects::create($dto->toArray());
            $this->eventDisp->dispatch(new CreateEvent($obj), CreateEvent::NAME);

            return $obj;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Обновляем объект
    */
    public function updateObject(ObjectDto $dto) : bool {
        // Проверяем валидность года
        if (!$this->utils->isValidYear($dto->getYear()) && !empty($dto->getYear())) {
            throw new \Exception("Не валидная дата");
        }

        $dto->setYear(null);

        // Обновляем
        try {
            $obj = Objects::find($dto->getId());

            // Говорим, что нужно запустить событие "До обновления объекта"
            $this->eventDisp->dispatch(new BeforeUpdateEvent($obj, $dto), BeforeUpdateEvent::NAME);

            if ($obj->update($dto->toArray())) {
                // Говорим, что нужно запустить событие "После обновления объекта"
                $this->eventDisp->dispatch(new AfterUpdateEvent($obj, $dto), AfterUpdateEvent::NAME);
                return true;
            };
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