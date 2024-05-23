<?php

namespace WWCrm\Services\Organization;

use WWCrm\Services\MainService;

// Dto
use WWCrm\Dto\OrgBillDto;

// Model
use WWCrm\Models\OrgBills;

final class OrgBillService extends MainService {
    /*
        Создание нового счета
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
        Удаление счета
    */
    public function deleteBill(int $id) : bool {
        if (OrgBills::find($id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /*
        Обновление счёта
    */
    public function updateBill(OrgBillDto $dto) : bool {
        $bill = OrgBills::find($dto->getId());

        /* 
            Если загружается файл со счетом
        */
        if(!empty($dto->getBillFileRequest())) {
            if($file_name = $this->saveBillFileFromRequest($dto->getBillFileRequest(), $dto)) {
                $dto->setBillFileName($file_name);
            } else {
                throw \Exception("Не удалось обновить файл счёта");
            }
        }

        /*
            Если есть новый файл, удаляем старый
        */
        if($dto->getBillFileName()) {
            $old_file_name = $bill->bill_file_name;
            $directory_file = $this->paths['fs']['organizations_bills'] . '/' . $dto->getOrganizationId() . '/' .  $old_file_name;

            if (file_exists($directory_file) && isset($old_file_name)) {
                unlink($directory_file);
            }
        }

        if ($bill->update($dto->toArray())) {
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