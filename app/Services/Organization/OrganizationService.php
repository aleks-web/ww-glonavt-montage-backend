<?php

namespace WWCrm\Services\Organization;

use WWCrm\Services\MainService;

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
            Валидность Email
        */
        if (!$this->utils->isValidEmail($dto->getEmail()) && !empty($dto->getEmail())) {
            throw new \Exception('Email введен не верно!');
        }

        /*
            Создание организации/клиента
        */
        try {
            return Organizations::create($dto->toArray());
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Обновление организации
    */
    public function updateOrganization(OrganizationDto $dto) : bool {
        $client = Organizations::find($dto->getId());

        /*
            Валидность Email
        */
        if (!$this->utils->isValidEmail($dto->getEmail()) && !empty($dto->getEmail())) {
            throw new \Exception('Email введен не верно!');
        }

        /*
            Обновление организации/клиента
        */
        if ($client) {
            try {
                if ($client->update($dto->toArray())) {
                    return true;
                } else {
                    throw new \Exception("Не удалось обновить организацию");
                }
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception("Не удалось найти организацию");
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
                    throw new \Exception("Не удалось сменить статус организации");
                }
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception("Не удалось найти организацию");
        }
    }

}