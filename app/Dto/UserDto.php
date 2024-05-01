<?php

namespace WWCrm\Dto;

class UserDto {
    private array $allFields = [];
    private $id;
    private $name;
    private $surname;
    private $patronymic;
    private $status;
    private $avatarFileName;
    private $postId;
    private $tel;
    private $email;
    private $birth;
    private $password;


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
                case 'surname':
                    if (isset($val)) {
                        $this->setSurname($val);
                    }
                    break;
                case 'patronymic':
                    if (isset($val)) {
                        $this->setPatronymic($val);
                    }
                    break;
                case 'avatar_file_name':
                    if (isset($val)) {
                        $this->setAvatarFileName($val);
                    }
                    break;
                case 'post_id':
                    if (isset($val)) {
                        $this->setPostId($val);
                    }
                    break;
                case 'tel':
                    if (isset($val)) {
                        $this->setTel($val);
                    }
                    break;
                case 'email':
                    if (isset($val)) {
                        $this->setEmail($val);
                    }
                    break;
                case 'birth':
                    if (isset($val)) {
                        $this->setBirth($val);
                    }
                    break;
                case 'password':
                    if (isset($val)) {
                        $this->setPassword($val);
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
        Фамилия
    */
    public function setSurname(string $surname) : void {
        $this->surname = $surname;
        $this->allFields['surname'] = $this->getSurname();
    }

    public function getSurname() : string|null {
        return $this->surname;
    }

    /*
        Отчество
    */
    public function setPatronymic(string $patronymic) : void {
        $this->patronymic = $patronymic;
        $this->allFields['patronymic'] = $this->getPatronymic();
    }

    public function getPatronymic() : string|null {
        return $this->patronymic;
    }

    /*
        Имя аватарки
    */
    public function setAvatarFileName(string $avatarFileName) : void {
        $this->avatarFileName = $avatarFileName;
        $this->allFields['avatar_file_name'] = $this->getAvatarFileName();
    }

    public function getAvatarFileName() : string|null {
        return $this->avatarFileName;
    }

    /*
        id должности
    */
    public function setPostId(string|int $postId) : void {
        if(empty($postId)) {
            $postId = null;
        }
        
        $this->postId = $postId;
        $this->allFields['post_id'] = $this->getPostId();
    }

    public function getPostId() : string|null {
        return $this->postId;
    }

    /*
        Телефон
    */
    public function setTel(string|int $tel) : void {
        $this->tel = preg_replace('/[^0-9]/', '', $tel);
        $this->allFields['tel'] = $this->getTel();
    }

    public function getTel() : string|int|null {
        return $this->tel;
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
        День рождения
    */
    public function setBirth(string $birth) : void {
        $this->birth = $birth;
        $this->allFields['birth'] = $this->getBirth();
    }

    public function getBirth() : string|null {
        return $this->birth;
    }

    /*
        Пароль
    */
    public function setPassword(string $pass) : void {
        $this->password = trim($pass);
        $this->allFields['password'] = $this->getPassword();
    }

    public function getPassword() : string|null {
        return $this->password;
    }

    /*
        Статус
    */
    public function setStatus(string|int $status) : void {
        $this->status = (int) $status;
        $this->allFields['status'] = $this->getStatus();
    }

    public function getStatus() : string|int|null {
        return $this->status;
    }
}