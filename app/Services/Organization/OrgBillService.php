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

        if(!empty($dto->getBillFileRequest())) {
            if($file_name = $this->saveBillFileFromRequest($dto->getBillFileRequest(), $dto)) {
                $dto->setBillFileName($file_name);
            } else {
                throw \Exception("Не удалось сохранить файл счёта");
            }
        }

        try {
            return OrgBills::create($dto->toArray());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /*
        Удаление договора
    */
    public function deleteBill(int $id) : bool {
        if (OrgBills::find($id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /*
        Сохранение файла из запроса
    */
    public function saveBillFileFromRequest(array $file_array, OrgBillDto $dto) : string|false {
        if (!$file_array || !$dto) {
            return false;
        }

        // Путь до хранения документов
        $save_dir = $this->paths['fs']['organizations_bills'];

        $save_dir_client = $save_dir . '/' . $dto->getOrganizationId();

        if(!is_dir($save_dir_client)) {
            mkdir($save_dir_client);
        }

        if (is_dir($save_dir_client)) {
            $old_file_path = $file_array['tmp_name'];

            $ext = pathinfo($file_array['name'], PATHINFO_EXTENSION);
            
            $file_name = 'orgId-' . $dto->getOrganizationId() . '__' . 'contractId-' . $dto->getContractId() . '__timestamp-' . time() . '.' . $ext;

            $new_file_path = $save_dir_client . '/' . $file_name;

            if (move_uploaded_file($old_file_path, $new_file_path)) {
                return $file_name;
            } else {
                return false;
            }
        }

        return false;
    }

}