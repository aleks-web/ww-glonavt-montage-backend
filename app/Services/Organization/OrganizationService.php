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

}