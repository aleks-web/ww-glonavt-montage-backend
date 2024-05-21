<?php

namespace WWCrm\Services\Organization;

use WWCrm\Services\MainService;

// Dto
use WWCrm\Dto\OrganizationDto;

// Model
use WWCrm\Models\Organizations;

// События
use WWCrm\Others\Events\Organizations\Create as CreateEvent;
use WWCrm\Others\Events\Organizations\Update as UpdateEvent;

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
            Проверка, есть ли клиент с таким ИНН
        */
        if (Organizations::where('inn', '=', $dto->getInn())->where('bic', '=', $dto->getBic())->first() && !empty($dto->getInn())) {
            throw new \Exception('Пользователь с таким ИНН уже существует!');
        }

        /*
            Проверка, есть ли клиент с таким БИК
        */
        if (Organizations::where('bic', '=', $dto->getBic())->first() && !empty($dto->getBic())) {
            throw new \Exception('Пользователь с таким БИК уже существует!');
        }

        /*
            Создание организации/клиента
        */
        try {
            $org = Organizations::create($dto->toArray());
            $this->eventDisp->dispatch(new CreateEvent($org), CreateEvent::NAME);

            return $org;
        } catch (\Illuminate\Database\QueryException $e) {
            throw $e;
        }
    }

    /*
        Обновление организации
    */
    public function updateOrganization(OrganizationDto $dto) : bool {
        $client = Organizations::find($dto->getId());

        /*
            Проверка, есть ли клиент с таким ИНН
        */
        if (!($client->inn == $dto->getInn()) && Organizations::where('inn', '=', $dto->getInn())->where('bic', '=', $dto->getBic())->first() && !empty($dto->getInn()) && !($client->bic == $dto->getBic()) && !empty($dto->getBic())) {
            throw new \Exception('Пользователь с таким ИНН и БИК уже существует!');
        }

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
                    $this->eventDisp->dispatch(new UpdateEvent($client), UpdateEvent::NAME);
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