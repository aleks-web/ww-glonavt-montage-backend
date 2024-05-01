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
    private $legalAddress;
    private $actualAddress;
    private $bankName;
    private $bic;
    private $checkingBillNum;
    private $correspondentBillNum;
    private $okpo;
    private $okato;
    private $managerId;


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
                        $this->setStatus($val);
                    }
                    break;
                case 'inn':
                    if (isset($val)) {
                        $this->setInn($val);
                    }
                    break;
                case 'email':
                    if (isset($val)) {
                        $this->setEmail($val);
                    }
                    break;
                case 'legal_address':
                    if (isset($val)) {
                        $this->setLegalAddress($val);
                    }
                    break;
                case 'actual_address':
                    if (isset($val)) {
                        $this->setActualAddress($val);
                    }
                    break;
                case 'bank_name':
                    if (isset($val)) {
                        $this->setBankName($val);
                    }
                    break;
                case 'bic':
                    if (isset($val)) {
                        $this->setBic($val);
                    }
                    break;
                case 'checking_bill_num':
                    if (isset($val)) {
                        $this->setCheckingBillNum($val);
                    }
                    break;
                case 'correspondent_bill_num':
                    if (isset($val)) {
                        $this->setCorrespondentBillNum($val);
                    }
                    break;
                case 'okpo':
                    if (isset($val)) {
                        $this->setOkpo($val);
                    }
                    break;
                case 'okato':
                    if (isset($val)) {
                        $this->setOkato($val);
                    }
                    break;
                case 'manager_id':
                    if (isset($val)) {
                        $this->setManagerId($val);
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

    /*
        Статус
    */
    public function setStatus(string|int $status) : void {
        $this->status = (int) $status;
        $this->allFields['status'] = $this->getStatus();
    }

    public function getStatus() : int|null {
        return $this->status;
    }

    /*
        ИНН
    */
    public function setInn(string|int $inn) : void {
        $this->inn = $inn;
        $this->allFields['inn'] = $this->getInn();
    }

    public function getInn() : int|string|null {
        return $this->inn;
    }

    /*
        Email
    */
    public function setEmail(string $email) : void {
        $this->email = $email;
        $this->allFields['email'] = $this->getEmail();
    }

    public function getEmail() : string|null {
        return $this->email;
    }

    /*
        legal_address
    */
    public function setLegalAddress(string $legalAddress) : void {
        $this->legalAddress = $legalAddress;
        $this->allFields['legal_address'] = $this->getLegalAddress();
    }

    public function getLegalAddress() : string|null {
        return $this->legalAddress;
    }

    /*
        actual_address
    */
    public function setActualAddress(string $actualAddress) : void {
        $this->actualAddress = $actualAddress;
        $this->allFields['actual_address'] = $this->getActualAddress();
    }

    public function getActualAddress() : string|null {
        return $this->actualAddress;
    }

    /*
        bank_name
    */
    public function setBankName(string $bankName) : void {
        $this->bankName = $bankName;
        $this->allFields['bank_name'] = $this->getBankName();
    }

    public function getBankName() : string|null {
        return $this->bankName;
    }

    /*
        bic
    */
    public function setBic(string $bic) : void {
        $this->bic = $bic;
        $this->allFields['bic'] = $this->getBic();
    }

    public function getBic() : string|null {
        return $this->bic;
    }

    /*
        checking_bill_num
    */
    public function setCheckingBillNum(string $checkingBillNum) : void {
        $this->checkingBillNum = $checkingBillNum;
        $this->allFields['checking_bill_num'] = $this->getCheckingBillNum();
    }

    public function getCheckingBillNum() : string|null {
        return $this->checkingBillNum;
    }

    /*
        correspondent_bill_num
    */
    public function setCorrespondentBillNum(string $correspondentBillNum) : void {
        $this->correspondentBillNum = $correspondentBillNum;
        $this->allFields['correspondent_bill_num'] = $this->getCorrespondentBillNum();
    }

    public function getCorrespondentBillNum() : string|null {
        return $this->correspondentBillNum;
    }

    /*
        okpo
    */
    public function setOkpo(string|int $okpo) : void {
        $this->okpo = $okpo;
        $this->allFields['okpo'] = $this->getOkpo();
    }

    public function getOkpo() : string|int|null {
        return $this->okpo;
    }

    /*
        okato
    */
    public function setOkato(string|int $okato) : void {
        $this->okato = $okato;
        $this->allFields['okato'] = $this->getOkato();
    }

    public function getOkato() : string|int|null {
        return $this->okato;
    }

    /*
        manager_id
    */
    public function setManagerId(string|int $managerId) : void {
        $this->managerId = (int) $managerId;
        $this->allFields['manager_id'] = $this->getManagerId();
    }

    public function getManagerId() : int|null {
        return $this->managerId;
    }
}