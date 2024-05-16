<?php

namespace WWCrm\Dto;

class OrgBillDto {
    private array $allFields = [];
    private $id;
    private $organizationId;

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
        id организации
    */
    public function setOrganizationId(int|string $organizationId) : void {
        $this->organizationId = (int) $organizationId;
        $this->allFields['organization_id'] = $this->getOrganizationId();
    }

    public function getOrganizationId() : int|null {
        return $this->organizationId;
    }

}