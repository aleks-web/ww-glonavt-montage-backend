<?php

namespace WWCrm\Dto;

class ObjectDto {
    private array $allFields = [];
    private int $id;
    private int $organizationId;
    private int|null $year = null;
    private string|null $brand = null;
    private string|null $model  = null;
    private string|null $gnum = null;
    private string|null $vin = null;
    private int|null $status = null;
    private string|null $color = null;
    private string|null $regDocNum = null;


    public function __construct(array $values) {
        foreach ($values as $key => $val) {
            switch ($key) {
                case 'id':
                    if (isset($val)) {
                        $this->id = $val;
                        $allFields['id'] = $val;
                    }
                    break;
                case 'year':
                    if (isset($val)) {
                        $this->year = $val;
                        $allFields['year'] = $val;
                    }
                    break;
                case 'brand':
                    if (isset($val)) {
                        $this->brand = $val;
                        $allFields['brand'] = $val;
                    }
                    break;
                case 'model':
                    if (isset($val)) {
                        $this->model = $val;
                        $allFields['model'] = $val;
                    }
                    break;
                case 'gnum':
                    if (isset($val)) {
                        $this->gnum = $val;
                        $allFields['gnum'] = $val;
                    }
                    break;
                case 'vin':
                    if (isset($val)) {
                        $this->vin = $val;
                        $allFields['vin'] = $val;
                    }
                    break;
                case 'status':
                    if (isset($val)) {
                        $this->status = $val;
                        $allFields['status'] = $val;
                    }
                    break;
                case 'color':
                    if (isset($val)) {
                        $this->color = $val;
                        $allFields['color'] = $val;
                    }
                    break;
                case 'reg_doc_num':
                    if (isset($val)) {
                        $this->regDocNum = $val;
                        $allFields['reg_doc_num'] = $val;
                    }
                    break;
            }
        }

        $this->allFields = $values;
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
        $this->status = $status;
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
    public function setOrganizationId(int $organizationId) : void {
        $this->organizationId = $organizationId;
    }

    public function getOrganizationId() : int {
        return $this->organizationId;
    }

    /*
        Год
    */
    public function setYear(int $year) : void {
        $this->year = str_replace(' ', '', $year);
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