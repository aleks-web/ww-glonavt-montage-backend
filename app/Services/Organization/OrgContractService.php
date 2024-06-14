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
        $contract = OrgContracts::find($id);
        $file_path = $this->paths['fs']['organizations_contracts'] . '/' . $contract->organization_id . '/' . $contract->contract_file_name;

        if (file_exists($file_path)) {
            if (!unlink($file_path)) {
                throw new \Exception('Не удалось удалить файл договора!');
            }
        }

        if ($contract->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /*
        Обновление договора
    */
    public function updateContract(OrgContractDto $dto) : bool {
        $contract = OrgContracts::find($dto->getId());
        $dto->setOrganizationId($contract->organization->id);

        if(empty($dto->getContractNum())) {
            throw new \Exception('Номер договора не заполнен!');
        }

        /*
            Если загружается новый файл
        */
        if(!empty($dto->getContractFileRequest())) {
            $file_name = $this->saveContractFileFromRequest($dto->getContractFileRequest(), $dto);
            $dto->setContractFileName($file_name);
        }

        /*
            Если есть новый файл, удаляем старый
        */
        if($dto->getContractFileName()) {
            $old_file_name = $contract->contract_file_name;
            $directory_file = $this->paths['fs']['organizations_contracts'] . '/' . $dto->getOrganizationId() . '/' .  $old_file_name;

            if (file_exists($directory_file) && isset($old_file_name)) {
                unlink($directory_file);
            }
        }

        if ($contract->update($dto->toArray())) {
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
            
            $file_name = 'orgid-' . $dto->getOrganizationId() . '__' . 'num-' . $dto->getContractNum() . '__timestamp-' . time() . '.' . $ext;

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