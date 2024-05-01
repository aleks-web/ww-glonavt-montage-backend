<?php

namespace WWCrm\Services\Organization;

use WWCrm\Services\MainService;

// Билдер для компонента
use WWCrm\Services\ComponentSelectBuilder;

// Dto
use WWCrm\Dto\OrganizationDto;

// Model
use WWCrm\Models\Organizations;

final class OrganizationService extends MainService {

    /*
        Создание организации
    */
    public function createOrganization(OrganizationDto $dto) : Organizations {

        /*
            Создание организации/клиента
        */
        try {
            return Organizations::create($dto->toArray());
        } catch (\Illuminate\Database\QueryException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
        Обновление организации
    */
    public function updateOrganization(OrganizationDto $dto) : bool {
        $client = Organizations::find($dto->getId());

        /*
            Проверяем валидность имени организации
        */
        if(!$this->utils->isValidFio($dto->getName())) {
            throw new Exception("В имени организации не должно быть посторонних симфолов и цифр");
        }

        /*
            Обновление организации/клиента
        */
        if ($client) {
            try {
                if ($client->update($dto->toArray())) {
                    return true;
                } else {
                    throw new Exception("Не удалось обновить организацию");
                }
            } catch (\Illuminate\Database\QueryException $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    /*
        Смена статуса организации
    */
    public function changeStatusOrganization(OrganizationDto $dto) : bool {
        $client = Organizations::find($dto->getId());

        /*
            Обновление организации/клиента
        */
        if ($client) {
            try {
                if ($client->update(['status' => $dto->getStatus()])) {
                    return true;
                } else {
                    throw new Exception("Не удалось сменить статус организации");
                }
            } catch (\Illuminate\Database\QueryException $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

}