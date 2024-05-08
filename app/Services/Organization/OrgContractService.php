<?php

namespace WWCrm\Services\Organization;

use WWCrm\Services\MainService;

// Dto
use WWCrm\Dto\OrgContractDto;

// Model
use WWCrm\Models\OrgContracts;

final class OrgContractService extends MainService {
    /*
        Создание нового договора
    */
    public function createContract(OrgContractDto $dto) : OrgContracts {

        if(empty($dto->getContractNum())) {
            throw new \Exception('Номер создаваемого договора не заполнен!');
        }

        if(empty($dto->getOrganizationId())) {
            throw new \Exception('Не задана организация, для которой создается договор!');
        }

        if(empty($dto->getContractFileRequest())) {
            throw new \Exception('Вы не загрузили документ');
        } else {
            $file_name = $this->saveContractFileFromRequest($dto->getContractFileRequest(), $dto);
            $dto->setContractFileName($file_name);
        }

        try {
            return OrgContracts::create($dto->toArray());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /*
        Удаление договора
    */
    public function deleteContract(int $id) : bool {
        if (OrgContracts::find($id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /*
        Сохранение файла из запроса
    */
    public function saveContractFileFromRequest(array $file_array, OrgContractDto $dto) : string|false {
        if (!$file_array || !$dto) {
            return false;
        }

        // Путь до хранения документов
        $save_dir = $this->paths['fs']['organizations_contracts'];

        $save_dir_client = $save_dir . '/' . $dto->getOrganizationId();

        if(!is_dir($save_dir_client)) {
            mkdir($save_dir_client);
        }

        if (is_dir($save_dir_client)) {
            $old_file_path = $file_array['tmp_name'];

            $ext = pathinfo($file_array['name'], PATHINFO_EXTENSION);
            
            $file_name = 'orgid:' . $dto->getOrganizationId() . '__' . 'num:' . $dto->getContractNum() . '__timestamp:' . time() . '.' . $ext;

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