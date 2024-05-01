<?php

namespace WWCrm\Dto;

// ТРЕБУЕТ РЕАЛИЗАЦИИ!!! РЕАЛИЗОВАТЬ!!!
class OrganizationDto {
    private array $allFields = [];
    private $id;
    private $name;
    private $status;
    private $inn;
    private $email;
    private $legal_address;
    private $actual_address;
    private $bank_name;
    private $bic;
    private $checking_bill_num;
    private $correspondent_bill_num;
    private $okpo;
    private $okato;
    private $manager_id;


    public function __construct(array $values) {
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
                case 'status':
                    if (isset($val)) {
                        $this->setSurname($val);
                    }
                    break;
                case 'inn':
                    if (isset($val)) {
                        $this->setPatronymic($val);
                    }
                    break;
                case 'email':
                    if (isset($val)) {
                        $this->setAvatarFileName($val);
                    }
                    break;
                case 'legal_address':
                    if (isset($val)) {
                        $this->setPostId($val);
                    }
                    break;
                case 'actual_address':
                    if (isset($val)) {
                        $this->setTel($val);
                    }
                    break;
                case 'bank_name':
                    if (isset($val)) {
                        $this->setEmail($val);
                    }
                    break;
                case 'bic':
                    if (isset($val)) {
                        $this->setBirth($val);
                    }
                    break;
                case 'checking_bill_num':
                    if (isset($val)) {
                        $this->setPassword($val);
                    }
                    break;
                case 'correspondent_bill_num':
                    if (isset($val)) {
                        $this->setPassword($val);
                    }
                    break;
                case 'okpo':
                    if (isset($val)) {
                        $this->setPassword($val);
                    }
                    break;
                case 'okato':
                    if (isset($val)) {
                        $this->setPassword($val);
                    }
                    break;
                case 'manager_id':
                    if (isset($val)) {
                        $this->setPassword($val);
                    }
                    break;
            }
        }
    }

    /*
        Возвращает массив данных
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
        return (int) $this->id;
    }

    /*
        Имя
    */
    public function setName(string $name) : void {
        $this->name = $name;
        $this->allFields['name'] = $this->getName();
    }

    public function getName() : string {
        return (string) $this->name;
    }
}