<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

use \WWCrm\Models\Users;

class Objects extends Model {

  /*
    Дефлтный статус. Означает, что запись не имеет статуса
  */
  const STATUS_NULL = 10;

  /*
    Активный статус
  */
  const STATUS_ACTIVE = 20;

  /*
    Возвращаем статус по его id
  */
  public static function getStatusName($status_id = false) {
    if ($status_id === self::STATUS_NULL) {
      return 'Не активный';
    } elseif ($status_id === self::STATUS_ACTIVE) {
      return 'Активный';
    } else {
      return false;
    }
  }

  // Разрешенные для записи поля
  protected $fillable = [
    'organization_id',
    'brand',
    'model',
    'gnum',
    'vin',
    'color',
    'year',
    'reg_doc_num',
    'user_add_id'
  ];

  // Получить все поля
  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }

  public function userAdded() {
    return $this->belongsTo(Users::class, 'user_add_id', 'id');
  }
}