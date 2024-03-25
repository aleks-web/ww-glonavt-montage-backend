<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class BookEquipments extends Model {

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

  /*
    Получить все статусы в виде массива
  */
  public static function getArrayStatuses() {
    return [
      self::STATUS_DELETED => self::getStatusName(self::STATUS_DELETED),
      self::STATUS_ACTIVE => self::getStatusName(self::STATUS_ACTIVE)
    ];
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

  // Кто добавил
  public function objects() {
    return $this->hasMany('\WWCrm\Models\ObjEquipments', 'equipment_id', 'id');
  }
}