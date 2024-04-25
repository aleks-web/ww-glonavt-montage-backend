<?php

namespace WWCrm\Dto;

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


    public function __construct(array $values) {
        foreach ($values as $key => $val) {
            switch ($key) {
                case 'organization_id':
                    if (isset($val)) {
                        $this->organizationId = $this->setOrganizationId($val);
                        $this->allFields['organization_id'] = $this->getOrganizationId();
                    }
                    break;
                case 'id':
                    if (isset($val)) {
                        $this->id = $this->setId($val);
                        $this->allFields['id'] = $this->getId();
                    }
                    break;
                case 'year':
                    if (isset($val)) {
                        $this->year = $this->setYear($val);
                        $this->allFields['year'] = $this->getYear();
                    }
                    break;
                case 'brand':
                    if (isset($val)) {
                        $this->brand = $this->setBrand($val);
                        $this->allFields['brand'] = $this->getBrand();
                    }
                    break;
                case 'model':
                    if (isset($val)) {
                        $this->model = $this->setModel($val);
                        $this->allFields['model'] = $this->getModel();
                    }
                    break;
                case 'gnum':
                    if (isset($val)) {
                        $this->gnum = $this->setGnum($val);
                        $this->allFields['gnum'] = $this->getGnum();
                    }
                    break;
                case 'vin':
                    if (isset($val)) {
                        $this->vin = $this->setVin($val);
                        $this->allFields['vin'] = $this->getVin();
                    }
                    break;
                case 'status':
                    if (isset($val)) {
                        $this->status = $this->setStatus($val);
                        $this->allFields['status'] = $this->getStatus();
                    }
                    break;
                case 'color':
                    if (isset($val)) {
                        $this->color = $this->setColor($val);
                        $this->allFields['color'] = $this->getColor();
                    }
                    break;
                case 'reg_doc_num':
                    if (isset($val)) {
                        $this->regDocNum = $this->setRegDocNum($val);
                        $this->allFields['reg_doc_num'] = $this->getRegDocNum();
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
        Id
    */
    public function setId(int $id) : void {
        $this->id = $id;
    }

    public function getId() : int|null {
        return $this->id;
    }

    /*
        Номер документа о регистрации
    */
    public function setRegDocNum(string $regDocNum) : void {
        $this->regDocNum = $regDocNum;
    }

    public function getRegDocNum() : string|null {
        return $this->regDocNum;
    }

    /*
        Цвет
    */
    public function setColor(string $color) : void {
        $this->color = $color;
    }

    public function getColor() : string|null {
        return $this->color;
    }

    /*
        Статус
    */
    public function setStatus(int $status) : void {
        $this->status = (int) $status;
    }

    public function getStatus() : int|null {
        return $this->status;
    }

    /*
        Vin номер
    */
    public function setVin(string $vin) : void {
        $this->vin = $vin;
    }

    public function getVin() : string|null {
        return $this->vin;
    }

    /*
        Гос.номер
    */
    public function setGnum(string $gnum) : void {
        $this->gnum = $gnum;
    }

    public function getGnum() : string|null {
        return $this->gnum;
    } 
    
    /*
        id организации
    */
    public function setOrganizationId(int|string $organizationId) : void {
        $this->organizationId = (int) $organizationId;
    }

    public function getOrganizationId() : int|null {
        return $this->organizationId;
    }

    /*
        Год
    */
    public function setYear(int|string $year) : void {
        $this->year = (int) str_replace(' ', '', $year);
    }

    public function getYear() : int|null {
        return $this->year;
    }

    /*
        Брэнд
    */
    public function setBrand(string $brand) : void {
        $this->brand = $brand;
    }

    public function getBrand() : string|null {
        return $this->brand;
    }

    /*
        Модель
    */
    public function setModel(string $model) : void {
        $this->model = $model;
    }

    public function getModel() : string|null {
        return $this->model;
    }

}