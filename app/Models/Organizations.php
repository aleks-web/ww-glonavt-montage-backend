<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class Organizations extends Model {

  /*
    Дефлтный статус. Означает, что запись не имеет статуса
  */
  const STATUS_NULL = 10;

  /*
    Активный статус
  */
  const STATUS_ACTIVE = 20;

  /*
    Архивный статус
  */
  const STATUS_ARCHIVE = 100;


  /*
    Возвращаем статус по его id
  */
  public static function getStatusName($status_id = false) {
    if ($status_id === self::STATUS_NULL) {
      return 'Не активный';
    } elseif ($status_id === self::STATUS_ACTIVE) {
      return 'Активный';
    } elseif($status_id === self::STATUS_ARCHIVE) {
      return 'Архив';
    } else {
      return false;
    }
  }

  /*
    Получить все статусы в виде массива
  */
  public static function getArrayStatuses() {
    return [
      self::STATUS_NULL => self::getStatusName(self::STATUS_NULL),
      self::STATUS_ACTIVE => self::getStatusName(self::STATUS_ACTIVE),
      self::STATUS_ARCHIVE => self::getStatusName(self::STATUS_ARCHIVE),
    ];
  }

  protected $fillable = [
    'name',
    'status',
    'inn',
    'director_tel',
    'director_fio',
    'email',
    'legal_address',
    'actual_address',
    'bank_name',
    'bic',
    'checking_bill_num',
    'correspondent_bill_num',
    'okpo',
    'okato',
    'manager_id'
  ];

  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }

  public function contactsPersons() {
      return $this->hasMany('\WWCrm\Models\OrgContactsPersons', 'organization_id', 'id');
  }
}