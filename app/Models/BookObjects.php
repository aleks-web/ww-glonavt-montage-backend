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

}