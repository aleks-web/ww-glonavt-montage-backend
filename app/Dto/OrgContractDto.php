<?php

namespace WWCrm\Dto;

class OrgContractDto {
    private array $allFields = [];
    private $id;
    private $organizationId;
    private $bookDocId;
    private $contractNum;
    private $dateStart;
    private $dateEnd;
    private $responsibleUserId;
    private $contractFileRequest;
    private $contractFileName;
    private $userAddId;

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
                case 'user_add_id':
                    if(isset($val)) {
                        $this->setUserAddId($val);
                    }
                    break;
                case 'book_doc_id':
                    if(isset($val)) {
                        $this->setBookDocId($val);
                    }
                    break;
                case 'contract_num':
                    if(isset($val)) {
                        $this->setContractNum($val);
                    }
                    break;
                case 'contract_date_start':
                    if(isset($val)) {
                        $this->setDateStart($val);
                    }
                    break;
                case 'contract_date_end':
                    if(isset($val)) {
                        $this->setDateEnd($val);
                    }
                    break;
                case 'responsible_user_id':
                    if(isset($val)) {
                        $this->setResponsibleUserId($val);
                    }
                    break;
                case 'contract_file_name':
                    if(isset($val)) {
                        $this->setContractFileName($val);
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
        Название файла договора
    */
    public function setContractFileName(string $contractFileName) : void {
        $this->contractFileName = $contractFileName;
        $this->allFields['contract_file_name'] = $this->getContractFileName();
    }

    public function getContractFileName() : string|null {
        return $this->contractFileName;
    }

    /*
        Файл $_FILES['файл'] из запроса
    */
    public function setContractFileRequest(array|null $contractFileRequest) : void {
        $this->contractFileRequest = $contractFileRequest;
    }

    public function getContractFileRequest() : array|null {
        return $this->contractFileRequest;
    }

    /*
        Id ответственного
    */
    public function setResponsibleUserId(int|string $responsibleUserId) : void {
        $this->responsibleUserId = (int) $responsibleUserId;
        $this->allFields['responsible_user_id'] = $this->getResponsibleUserId();
    }

    public function getResponsibleUserId() : int|null {
        return $this->responsibleUserId;
    }

    /*
        Дата начала
    */
    public function setDateStart(string $dateStart) : void {
        $this->dateStart = $dateStart;
        $this->allFields['contract_date_start'] = $this->getDateStart();
    }

    public function getDateStart() : string|null {
        return $this->dateStart;
    }

    /*
        Дата окончания договора
    */
    public function setDateEnd(string $dateEnd) : void {
        $this->dateEnd = $dateEnd;
        $this->allFields['contract_date_end'] = $this->getDateEnd();
    }

    public function getDateEnd() : string|null {
        return $this->dateEnd;
    }


    /*
        Номер договора
    */
    public function setContractNum(int|string $contractNum) : void {
        $this->contractNum = (string) $contractNum;
        $this->allFields['contract_num'] = $this->getContractNum();
    }

    public function getContractNum() : string|null {
        return $this->contractNum;
    }

    /*
        Id тип договора из справочника
    */
    public function setBookDocId(int $bookDocId) : void {
        $this->bookDocId = $bookDocId;
        $this->allFields['book_doc_id'] = $this->getBookDocId();
    }

    public function getBookDocId() : int|null {
        return $this->bookDocId;
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