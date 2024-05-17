<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
    Возвращаем id статуса по его названию
  */
  public static function getStatusId($status_name = false) {
    if ($status_name === 'STATUS_NULL') {
      return self::STATUS_NULL;
    } elseif ($status_name === 'STATUS_ACTIVE') {
      return self::STATUS_ACTIVE;
    } elseif($status_name === 'STATUS_ARCHIVE') {
      return self::STATUS_ACTIVE;
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

  /*
    Получить все статусы в виде именованного массива
  */
  public static function getArrayStatusesNamed() {
    return [
      'STATUS_NULL' => self::getStatusId('STATUS_NULL'),
      'STATUS_ACTIVE' => self::getStatusId('STATUS_ACTIVE'),
      'STATUS_ARCHIVE' => self::getStatusId('STATUS_ARCHIVE'),
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

  /*
    Получает контактных персон
  */
  public function contactsPersons() {
    return $this->hasMany('\WWCrm\Models\OrgContactsPersons', 'organization_id', 'id');
  }

  /*
    Получает объекты
  */
  public function objects() {
    return $this->hasMany('\WWCrm\Models\Objects', 'organization_id', 'id');
  }

  // Назначенный менеджер
  public function manager() {
    return $this->belongsTo('\WWCrm\Models\Users', 'manager_id', 'id');
  }

  /*
    Договоры
  */
  public function contracts() {
    return $this->hasMany('\WWCrm\Models\OrgContracts', 'organization_id', 'id');
  }

  /**
   * Получить счета
  */
  public function bills(): HasManyThrough
  {
      return $this->hasManyThrough('\WWCrm\Models\OrgBills', '\WWCrm\Models\OrgContracts', 'organization_id', 'contract_id', 'id', 'id');
  }
}