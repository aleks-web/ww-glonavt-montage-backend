<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class Objects extends Model {

  /*
    Дефлтный статус. Означает, что запись не имеет статуса
  */
  const STATUS_NULL = 0;

  /*
    Активный статус
  */
  const STATUS_ACTIVE = 1;

  /*
    Возвращаем статус по его id
  */
  public static function getStatusName($status_id = false) {
    if ($status_id === 0) {
      return 'Не активный';
    } elseif ($status_id === 1) {
      return 'Активный';
    } else {
      return false;
    }
  }

  // Разрешенные для записи поля
  protected $fillable = [
    'organization_id',
    'model',
    'gnum',
    'vin'
  ];

  // Получить все поля
  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }
}