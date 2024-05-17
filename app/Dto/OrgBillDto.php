<?php

namespace WWCrm\Dto;

class OrgBillDto {
    private array $allFields = [];
    private $id;
    private $contractId;
    private $organizationId;
    private $comment;
    private $sum;
    private $status;

    private $billFileRequest;
    private $billFileName;

    public function __construct(array $values) {
        foreach ($values as $key => $val) {
            switch ($key) {
                case 'contract_id':
                    if (isset($val)) {
                        $this->setContractId($val);
                    }
                    break;
                case 'organization_id':
                    if (isset($val)) {
                        $this->setOrganizationId($val);
                    }
                    break;
                case 'comment':
                    if (isset($val)) {
                        $this->setComment($val);
                    }
                    break;
                case 'sum':
                    if (isset($val)) {
                        $this->setSum($val);
                    }
                    break;
                case 'id':
                    if (isset($val)) {
                        $this->setId($val);
                    }
                    break;
                case 'bill_file_name':
                    if (isset($val)) {
                        $this->setBillFileName($val);
                    }
                    break;
                case 'status':
                    if (isset($val)) {
                        $this->setStatus($val);
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
        Статус
    */
    public function setStatus(int $status) : void {
        $this->status = $status;
        $this->allFields['status'] = $this->getStatus();
    }

    public function getStatus() : int|null {
        return $this->status;
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
        Название файла счета
    */
    public function setBillFileName(string $billFileName) : void {
        $this->billFileName = $billFileName;
        $this->allFields['bill_file_name'] = $this->getBillFileName();
    }

    public function getBillFileName() : string|null {
        return $this->billFileName;
    }

    /*
        $_FILE['file']
    */
    public function setBillFileRequest(array $billFileRequest) : void {
        $this->billFileRequest = $billFileRequest;
    }

    public function getBillFileRequest() : array|null {
        return $this->billFileRequest;
    }

    /*
        sum
    */
    public function setSum(int|float|string $sum) : void {
        $sum = trim($sum);
        $sum = str_replace(' ', '', $sum);
        $sum = str_replace(',', '.', $sum);
        $this->sum = (float) $sum;
        $this->allFields['sum'] = $this->getSum();
    }

    public function getSum() : float|null {
        return $this->sum;
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
        id договора
    */
    public function setContractId(int|string $contractId) : void {
        $this->contractId = (int) $contractId;
        $this->allFields['contract_id'] = $this->getContractId();
    }

    public function getContractId() : int|null {
        return $this->contractId;
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

}