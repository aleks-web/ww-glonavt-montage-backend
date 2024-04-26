<?php

namespace WWCrm\Dto;

class OrganizationDto {
    private array $allFields = [];
    private $id;


    public function __construct(array $values) {
        foreach ($values as $key => $val) {
            switch ($key) {
                case 'id':
                    if (isset($val)) {
                        $this->setId($val);
                        $this->allFields['id'] = $this->getId();
                    }
                    break;
            }
        }
    }
}