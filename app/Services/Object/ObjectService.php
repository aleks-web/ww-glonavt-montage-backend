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
            if (!$this->utils->isValidYear($dto->getYear())) {
                throw new Exception("Не валидная дата");
            }

            // Создаем объект
            return Objects::create([
                'organization_id' => $dto->getOrganizationId(),
                'year' => $dto->getYear(),
                'brand' => $dto->getBrand(),
                'model' => $dto->getModel(),
                'gnum' => $dto->getGnum(),
                'vin' => $dto->getVin(),
                'status' => $dto->getStatus(),
                'color' => $dto->getColor(),
                'reg_doc_num' => $dto->getRegDocNum(),
                'user_add_id' => $this->currentUser->getId()
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }
}