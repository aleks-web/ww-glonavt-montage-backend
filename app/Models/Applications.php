<?php

namespace WWCrm\Models;

class Applications extends \Illuminate\Database\Eloquent\Model {

  /*
    Дефлтный статус. Означает, что запись не имеет статуса
  */
  const STATUS_NEW = 10;

  /*
    Активный статус. Заявка в работе
  */
  const STATUS_INWORK = 20;

  /*
    Готово
  */
  const STATUS_READY = 30;

  /*
    Возвращаем статус по его id
  */
  public static function getStatusName($status_id = false) {
    if ($status_id === self::STATUS_NEW) {
      return 'Новая';
    } elseif ($status_id === self::STATUS_INWORK) {
      return 'В работе';
    } elseif ($status_id === self::STATUS_READY) {
        return 'Выполнено';
    } else {
      return false;
    }
  }

  // Разрешенные для записи поля
  protected $fillable = [
    'object_id',
    'status',
    'user_add_id'
  ];

  // Получить все поля
  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }

  // Кто добавил
  public function userAdded() {
    return $this->belongsTo('\WWCrm\Models\Users', 'user_add_id', 'id');
  }

  // Объект для которого создана заявка
  public function object() {
    return $this->belongsTo('\WWCrm\Models\Objects', 'object_id', 'id');
  }

}