<?php

namespace WWCrm\Dto;

class ObjDocDto {
    private array $allFields = [];
    private $id;
    private $objectId;
    private $comment;
    private $userAddId;

    private $docFileRequest; // Из запроса $_FILES['какой-то файл']
    private $docFileName; // Название сохраненного файла из docFileRequest

    public function __construct(array $values = null) {
        if ($values) {
            foreach ($values as $key => $val) {
                switch ($key) {
                    case 'id':
                        if (isset($val)) {
                            $this->setId($val);
                        }
                        break;
                    case 'name':
                        if (isset($val)) {
                            $this->setName($val);
                        }
                        break;
                    case 'object_id':
                        if (isset($val)) {
                            $this->setObjectId($val);
                        }
                        break;
                    case 'comment':
                        if (isset($val)) {
                            $this->setComment($val);
                        }
                        break;
                    case 'doc_file_name':
                        if (isset($val)) {
                            $this->setDocFileName($val);
                        }
                        break;
                    case 'user_add_id':
                        if (isset($val)) {
                            $this->setUserAddId($val);
                        }
                        break;
                }
            }
        }
    }

    /*
        Возвращает массив тех данных
    */
    public function toArray() : array {
        return $this->allFields;
    }

    /*
        Id
    */
    public function setId(int $id) : void {
        $this->id = $id;
        $this->allFields['id'] = $this->getId();
    }

    public function getId() : int|null {
        return $this->id;
    }

    /*
        id объекта
    */
    public function setObjectId(int|string $objectId) : void {
        $this->objectId = (int) $objectId;
        $this->allFields['object_id'] = $this->getObjectId();
    }

    public function getObjectId() : int|null {
        return $this->objectId;
    }

    /*
        Кто добавил user_add_id в бд
    */
    public function setUserAddId(int|string $userAddId) : void {
        $this->userAddId = (int) $userAddId;
        $this->allFields['user_add_id'] = $this->getUserAddId();
    }

    public function getUserAddId() : int|null {
        return $this->userAddId;
    }

    /*
        Название файла счета
    */
    public function setDocFileName(string $docFileName) : void {
        $this->docFileName = $docFileName;
        $this->allFields['doc_file_name'] = $this->getDocFileName();
    }

    public function getDocFileName() : string|null {
        return $this->docFileName;
    }

    /*
        $_FILE['file']
    */
    public function setDocFileRequest(array $docFileRequest) : void {
        $this->docFileRequest = $docFileRequest;
    }

    public function getDocFileRequest() : array|null {
        return $this->docFileRequest;
    }

    /*
        comment
    */
    public function setComment(string $comment) : void {
        $this->comment = trim($comment);
        $this->allFields['comment'] = $this->getComment();
    }

    public function getComment() : string|null {
        return $this->comment;
    }

    /*
        Имя файла
    */
    public function setName(string $name) : void {
        $this->name = trim($name);
        $this->allFields['name'] = $this->getName();
    }

    public function getName() : string|null {
        return $this->name;
    }

}