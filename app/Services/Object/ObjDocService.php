<?php

namespace WWCrm\Services\Object;

// Главный сервис
use WWCrm\Services\MainService;

// Модели
use WWCrm\Models\ObjDocs;


final class ObjDocService extends MainService {
    /*
        Создание документа объекта
    */
    public function createDoc(ObjectDto $dto) : ObjDocs {
        try {
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /*
        Обновляем документа объект
    */
    public function updateDoc(ObjectDto $dto) : bool {
        // Обновляем
        try {
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}