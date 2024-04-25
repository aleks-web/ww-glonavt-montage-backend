<?php

namespace WWCrm\Dto;

class ObjectDto {
    private int $organizationId;
    private int|null $year = null;
    private string|null $brand = null;
    private string|null $model  = null;
    private string|null $gnum = null;
    private string|null $vin = null;
    private int|null $status = null;
    private string|null $color = null;
    private string|null $regDocNum = null;

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