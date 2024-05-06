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
        Сохранение файла из запроса
    */
    public function saveContractFileFromRequest(array $file_array, OrgContractDto $dto = null) : string|false {
        if (!$file_array) {
            return false;
        }

        // Путь до хранения документов
        $save_dir = $this->paths['fs']['organizations_contracts'];

        if (is_dir($save_dir)) {
            $old_file_path = $file_array['tmp_name'];

            $ext = pathinfo($file_array['name'], PATHINFO_EXTENSION);

            if (!$dto) {
                $file_name = time() . '.' . $ext;
            } else {
                $file_name = 'orgid:' . $dto->getOrganizationId() . '__' . 'num:' . $dto->getContractNum() . '__timestamp:' . time() . '.' . $ext;
            }

            $new_file_path = $save_dir . '/' . $file_name;

            if (move_uploaded_file($old_file_path, $new_file_path)) {
                return $file_name;
            } else {
                return false;
            }
        }

        return false;
    }

}