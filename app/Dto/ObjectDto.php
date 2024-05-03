<?php

namespace WWCrm\Dto;

use WWCrm\Models\Objects;

class ObjectDto {
    private array $allFields = [];
    private $id;
    private $organizationId;
    private $year;
    private $status;
    private $brand;
    private $model ;
    private $gnum;
    private $vin;
    private $color;
    private $regDocNum;
    private $userAddId;
    private $objectPhotoRequest;
    private $objectPhotoFileName;


    public function __construct(array $values) {
        foreach ($values as $key => $val) {
            switch ($key) {
                case 'organization_id':
                    if (isset($val)) {
                        $this->setOrganizationId($val);
                    }
                    break;
                case 'id':
                    if (isset($val)) {
                        $this->setId($val);
                    }
                    break;
                case 'year':
                    if (isset($val)) {
                        $this->setYear($val);
                    }
                    break;
                case 'brand':
                    if (isset($val)) {
                        $this->setBrand($val);
                    }
                    break;
                case 'model':
                    if (isset($val)) {
                        $this->setModel($val);
                    }
                    break;
                case 'gnum':
                    if (isset($val)) {
                        $this->setGnum($val);
                    }
                    break;
                case 'vin':
                    if (isset($val)) {
                        $this->setVin($val);
                    }
                    break;
                case 'status':
                    if (isset($val)) {
                        $this->setStatus($val);
                    }
                    break;
                case 'color':
                    if (isset($val)) {
                        $this->setColor($val);
                    }
                    break;
                case 'reg_doc_num':
                    if (isset($val)) {
                        $this->setRegDocNum($val);
                    }
                    break;
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
       Название файла с расширением. Фото объекта
    */
    public function setObjectPhotoFileName(string $objectPhotoFileName) : void {
        $this->objectPhotoFileName = $objectPhotoFileName;
        $this->allFields['photo_file_name'] = $this->getObjectPhotoFileName();
    }

    public function getObjectPhotoFileName() : string|null {
        return $this->objectPhotoFileName;
    }

    /*
        Массив данных полученных из $_FILES['фото_объекта']
    */
    public function setObjectPhotoRequest(array $objectPhotoRequest) : void {
        $this->objectPhotoRequest = $objectPhotoRequest;
        $this->allFields['object_photo_request'] = $this->getObjectPhotoRequest();
    }

    public function getObjectPhotoRequest() : array|null {
        return $this->objectPhotoRequest;
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
        Номер документа о регистрации
    */
    public function setRegDocNum(string $regDocNum) : void {
        $this->regDocNum = $regDocNum;
        $this->allFields['reg_doc_num'] = $this->getRegDocNum();
    }

    public function getRegDocNum() : string|null {
        return $this->regDocNum;
    }

    /*
        Цвет
    */
    public function setColor(string $color) : void {
        $this->color = $color;
        $this->allFields['color'] = $this->getColor();
    }

    public function getColor() : string|null {
        return $this->color;
    }

    /*
        Статус
    */
    public function setStatus(int $status) : void {
        $this->status = (int) $status;
        $this->allFields['status'] = $this->getStatus();
    }

    public function getStatus() : int|null {
        return $this->status;
    }

    /*
        Vin номер
    */
    public function setVin(string $vin) : void {
        $this->vin = $vin;
        $this->allFields['vin'] = $this->getVin();
    }

    public function getVin() : string|null {
        return $this->vin;
    }

    /*
        Гос.номер
    */
    public function setGnum(string $gnum) : void {
        $this->gnum = $gnum;
        $this->allFields['gnum'] = $this->getGnum();
    }

    public function getGnum() : string|null {
        return $this->gnum;
    } 
    
    /*
        id организации
    */
    public function setOrganizationId(int|string $organizationId) : void {
        $this->organizationId = (int) $organizationId;
        $this->allFields['organization_id'] = $this->getOrganizationId();
    }

    public function getOrganizationId() : int|null {
        return $this->organizationId;
    }

    /*
        Год
    */
    public function setYear(int|string $year) : void {
        $this->year = str_replace(' ', '', $year);
        $this->allFields['year'] = $this->getYear();
    }

    public function getYear() {
        return $this->year;
    }

    /*
        Брэнд
    */
    public function setBrand(string $brand) : void {
        $this->brand = $brand;
        $this->allFields['brand'] = $this->getBrand();
    }

    public function getBrand() : string|null {
        return $this->brand;
    }

    /*
        Модель
    */
    public function setModel(string $model) : void {
        $this->model = $model;
        $this->allFields['model'] = $this->getModel();
    }

    public function getModel() : string|null {
        return $this->model;
    }

}