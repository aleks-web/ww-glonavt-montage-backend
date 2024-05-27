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
        Обновление документа объекта
    */
    public function updateDoc(ObjDocDto $dto) {
        $doc = ObjDocs::find($dto->getId());

        $dto->setObjectId($doc->object_id);

        if (!empty($dto->getDocFileRequest())) {
            $file_name = $this->saveDocFileFromRequest($dto);
            $dto->setDocFileName($file_name);
            $this->deleteDocFileByDocId((int) $doc->id);
        }

        try {
            $doc->update($dto->toArray());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Удаляем документ объекта
    */
    public function deleteDoc(ObjDocDto $dto) : void {
        if (empty($dto->getId())) {
            throw new \Exception("Id документа не задан. Невозможно определить удаляемый документ!");
        }

        // Удаляем
        try {
            $this->deleteDocFileByDocId($dto->getId());
            ObjDocs::find($dto->getId())->delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Удаление файла документа по id записи
    */
    public function deleteDocFileByDocId(int $id) : void {
        $doc = ObjDocs::find($id);

        $directory_file = $this->paths['fs']['object_docs'] . '/' . $doc->object_id . '/' .  $doc->doc_file_name;

        if (file_exists($directory_file)) {
            unlink($directory_file);
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
            
            $file_name = 'objId-' . $dto->getObjectId() . '__timestamp-' . time() . '__rand-' . rand(1, 1000) . '.' . $ext;

            $new_file_path = $save_dir_object_doc . '/' . $file_name;

            if (move_uploaded_file($old_file_path, $new_file_path)) {
                return $file_name;
            } else {
                return false;
            }
        }

        return false;
    }

    /*
        Сохранение по массиву $_FILES['file']
    */
    public function createDocsFromArraysRequest(array $files_array, int $obj_id) {
        if (!$obj_id && !$files_array) {
            return false;
        }

        foreach ($files_array as $file_key => $file_array) {
            $dto = new ObjDocDto();
            $dto->setObjectId($obj_id);
            $dto->setDocFileRequest($file_array);

            $this->createDoc($dto);
        }
    }
}