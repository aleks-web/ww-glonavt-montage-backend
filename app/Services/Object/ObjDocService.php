<?php

namespace WWCrm\Services\Object;

// Главный сервис
use WWCrm\Services\MainService;

// Dto
use WWCrm\Dto\ObjDocDto;

// Модели
use WWCrm\Models\ObjDocs;


final class ObjDocService extends MainService {
    /*
        Создание документа объекта
    */
    public function createDoc(ObjDocDto $dto) : ObjDocs {
        if (empty($dto->getDocFileRequest())) {
            throw new \Exception("Вы не загрузили документ!");
        } else {
            $file_name = $this->saveDocFileFromRequest($dto);
            $dto->setDocFileName($file_name);
        }

        // Если не задан name, задаем ему текущий timestamp
        if(empty($dto->getName())) {
            $dto->setName('doc_' . time());
        }

        // Если добавляемый юзер не задан, делаем текущего пользователя
        if(empty($dto->getUserAddId())) {
            $dto->setUserAddId($this->currentUser->getId());
        }

        try {
            return ObjDocs::create($dto->toArray());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Обновляем документ объекта
    */
    public function updateDoc(ObjDocDto $dto) : bool {
        // Обновляем
        try {
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Удаляем документ объекта
    */
    public function deleteDoc(ObjDocDto $dto) : bool {
        if (empty($dto->getId())) {
            throw new \Exception("Id документа не задан. Невозможно определить удаляемый документ!");
        }

        // Удаляем
        try {
            if (ObjDocs::find($dto->getId())->delete()) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Сохранение документа объекта из запроса
    */
    public function saveDocFileFromRequest(ObjDocDto $dto) {
        if (!$dto) {
            return false;
        }

        // Путь до хранения документов
        $save_dir = $this->paths['fs']['object_docs'];

        $save_dir_object_doc = $save_dir . '/' . $dto->getObjectId();

        if(!is_dir($save_dir_object_doc)) {
            mkdir($save_dir_object_doc);
        }

        if (is_dir($save_dir_object_doc)) {
            $file_array = $dto->getDocFileRequest();
            $old_file_path = $file_array['tmp_name'];

            $ext = pathinfo($file_array['name'], PATHINFO_EXTENSION);
            
            $file_name = 'objId-' . $dto->getObjectId() . '__timestamp-' . time() . '.' . $ext;

            $new_file_path = $save_dir_object_doc . '/' . $file_name;

            if (move_uploaded_file($old_file_path, $new_file_path)) {
                return $file_name;
            } else {
                return false;
            }
        }

        return false;
    }
}