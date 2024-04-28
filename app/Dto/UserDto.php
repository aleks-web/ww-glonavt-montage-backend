<?php

namespace WWCrm\Dto;

class UserDto {
    private array $allFields = [];
    private $id;
    private $name;
    private $surname;
    private $patronymic;
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
                        $this->allFields['id'] = $this->getId();
                    }
                    break;
                case 'name':
                    if (isset($val)) {
                        $this->setName($val);
                        $this->allFields['name'] = $this->getName();
                    }
                    break;
                case 'surname':
                    if (isset($val)) {
                        $this->setSurname($val);
                        $this->allFields['surname'] = $this->getSurname();
                    }
                    break;
                case 'patronymic':
                    if (isset($val)) {
                        $this->setPatronymic($val);
                        $this->allFields['patronymic'] = $this->getPatronymic();
                    }
                    break;
                case 'avatar_file_name':
                    if (isset($val)) {
                        $this->setAvatarFileName($val);
                        $this->allFields['avatar_file_name'] = $this->getAvatarFileName();
                    }
                    break;
                case 'post_id':
                    if (isset($val)) {
                        $this->setPostId($val);
                        $this->allFields['post_id'] = $this->getPostId();
                    }
                    break;
                case 'tel':
                    if (isset($val)) {
                        $this->setTel($val);
                        $this->allFields['tel'] = $this->getTel();
                    }
                    break;
                case 'email':
                    if (isset($val)) {
                        $this->setEmail($val);
                        $this->allFields['email'] = $this->getEmail();
                    }
                    break;
                case 'birth':
                    if (isset($val)) {
                        $this->setBirth($val);
                        $this->allFields['birth'] = $this->getBirth();
                    }
                    break;
                case 'password':
                    if (isset($val)) {
                        $this->setPassword($val);
                        $this->allFields['password'] = $this->getPassword();
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
    }

    public function getId() : int|null {
        return (int) $this->id;
    }

    /*
        Имя
    */
    public function setName(string $name) : void {
        $this->name = $name;
    }

    public function getName() : string {
        return (string) $this->name;
    }

    /*
        Фамилия
    */
    public function setSurname(string $surname) : void {
        $this->surname = $surname;
    }

    public function getSurname() : string|null {
        return $this->surname;
    }

    /*
        Отчество
    */
    public function setPatronymic(string $patronymic) : void {
        $this->patronymic = $patronymic;
    }

    public function getPatronymic() : string|null {
        return $this->patronymic;
    }

    /*
        Имя аватарки
    */
    public function setAvatarFileName(string $avatarFileName) : void {
        $this->avatarFileName = $avatarFileName;
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
    }

    public function getPostId() : string|null {
        return $this->postId;
    }

    /*
        Телефон
    */
    public function setTel(string|int $tel) : void {
        $this->tel = $tel;
    }

    public function getTel() : string|int|null {
        return $this->tel;
    }

    /*
        Email
    */
    public function setEmail(string $email) : void {
        $this->email = $email;
    }

    public function getEmail() : string|null {
        return $this->email;
    }

    /*
        День рождения
    */
    public function setBirth(string $birth) : void {
        $this->birth = $birth;
    }

    public function getBirth() : string|null {
        return $this->birth;
    }

    /*
        Пароль
    */
    public function setPassword(string $pass) : void {
        $this->password = $pass;
    }

    public function getPassword() : string|null {
        return $this->password;
    }
}