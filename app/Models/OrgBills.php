<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class OrgBills extends Model {

  /*
    Счет оплачен
  */
  const STATUS_PAID = 10;

  /*
    Счет не оплачет
  */
  const STATUS_NOTPAID = 20;

  /*
    Возвращаем статус по его id
  */
  public static function getStatusName($status_id = false) {
    if ($status_id === self::STATUS_PAID) {
      return 'Оплачен';
    } elseif ($status_id === self::STATUS_NOTPAID) {
      return 'Не оплачен';
    } else {
      return false;
    }
  }

  /*
    Возвращаем id статуса по его названию
  */
  public static function getStatusId($status_name = false) {
    if ($status_name === 'STATUS_PAID') {
      return self::STATUS_PAID;
    } elseif ($status_name === 'STATUS_NOTPAID') {
      return self::STATUS_NOTPAID;
    } else {
      return false;
    }
  }

  /*
    Получить все статусы в виде массива
  */
  public static function getArrayStatuses() {
    return [
      self::STATUS_PAID => self::getStatusName(self::STATUS_PAID),
      self::STATUS_NOTPAID => self::getStatusName(self::STATUS_NOTPAID),
    ];
  }

  /*
    Получить все статусы в виде именованного массива
  */
  public static function getArrayStatusesNamed() {
    return [
      'STATUS_PAID' => self::getStatusId('STATUS_PAID'),
      'STATUS_NOTPAID' => self::getStatusId('STATUS_NOTPAID'),
    ];
  }

  protected $fillable = [
    'contract_id',
    'bill_file_name',
    'sum',
    'status',
    'comment'
  ];

  // возвращает fillable
  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }

}