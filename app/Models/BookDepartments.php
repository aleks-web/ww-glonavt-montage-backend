<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

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

}