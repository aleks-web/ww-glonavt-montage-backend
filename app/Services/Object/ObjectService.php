<?php

namespace WWCrm\Services\Object;

// Главный сервис
use WWCrm\Services\MainService;

// Объекты
use WWCrm\Models\Objects;

// Dto
use WWCrm\Dto\ObjectDto;


use Exception;

final class ObjectService extends MainService {
    public function createObject(ObjectDto $dto) : Objects {
        try {

            // Проверяем валидность года
            if ($dto->getYear() != null && $dto->getYear() != '') {
                if (!$this->utils->isValidYear($dto->getYear())) {
                    throw new Exception("Не валидный год");
                }
            }

            $data = $dto->toArray();
            $data['user_add_id'] = $this->currentUser->getId();

            // Создаем объект
            return Objects::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
        Обновляем объект
    */
    public function updateObject(ObjectDto $dto) : bool {
        // Проверяем валидность года
        if (!$this->utils->isValidYear($dto->getYear())) {
            throw new Exception("Не валидная дата");
        }

        // Обновляем
        try {
            return Objects::find($dto->getId())->update($dto->toArray());
        } catch (\Illuminate\Database\QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}