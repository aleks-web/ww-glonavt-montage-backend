<?php

namespace WWCrm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class BookDepartments extends Model {

  public $timestamps = false; // Отключаем даты в бд

  // Разрешенные для записи поля
  protected $fillable = [
    'name',
    'description'
  ];

  /*
    Получает должности в этом отделе
  */
  public function posts() {
    return $this->hasMany('\WWCrm\Models\BookPosts', 'department_id', 'id');
  }

  /**
   * Получить всех пользователей в департаменте
  */
  public function users(): HasManyThrough
  {
      return $this->hasManyThrough('\WWCrm\Models\Users', '\WWCrm\Models\BookPosts', 'department_id', 'post_id', 'id', 'id');
  }

}