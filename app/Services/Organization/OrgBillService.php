<?php

namespace WWCrm\Services\Organization;

use WWCrm\Services\MainService;

// Dto
use WWCrm\Dto\OrgBillDto;

// Model
use WWCrm\Models\OrgBills;

final class OrgBillService extends MainService {
    /*
        Создание нового договора
    */
    public function createBill(OrgBillDto $dto) : OrgBills {

        // if(empty($dto->getContractNum())) {
        //     throw new \Exception('Номер создаваемого договора не заполнен!');
        // }

        try {
            return OrgBills::create($dto->toArray());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /*
        Удаление договора
    */
    public function deleteContract(int $id) : bool {
        if (OrgBills::find($id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

}