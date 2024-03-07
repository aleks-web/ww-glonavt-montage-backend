<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class BookEquipment extends Model {

  /*
    Статус означающий, что запись удалена
  */
  const STATUS_DELETED = 0;

  /*
    Активный статус. Дефолтный в миграции
  */
  const STATUS_ACTIVE = 1;

  /*
    Возвращаем статус по его id
  */
  public static function getStatusName($status_id = false) {
    if ($status_id === self::STATUS_DELETED) {
      return 'Удален';
    } elseif ($status_id === self::STATUS_ACTIVE) {
      return 'Активный';
    } else {
      return false;
    }
  }

  // Разрешенные для записи поля
  protected $fillable = [
    'status',
    'name',
    'field_properties'
  ];

  // Получить все поля
  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }

  public function userAdded() {
    return $this->belongsTo(Users::class, 'user_add_id', 'id');
  }
}