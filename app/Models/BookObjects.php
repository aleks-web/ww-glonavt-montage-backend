<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class BookObjects extends Model {

  public $timestamps = false; // Отключаем даты в бд

  // Разрешенные для записи поля
  protected $fillable = [
    'name',
    'description'
  ];

  /*
    Получает объекты принадлежащих к этому справочнику
  */
  public function objects() {
    return $this->hasMany('\WWCrm\Models\Objects', 'book_object_id', 'id');
  }

}