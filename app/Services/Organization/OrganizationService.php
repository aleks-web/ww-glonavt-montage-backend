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
        $client = Organizations::create($dto->toArray());

        return $client;
    }

}