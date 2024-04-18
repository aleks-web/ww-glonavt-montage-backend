<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class BookPosts extends Model {

  public $timestamps = false; // Отключаем даты в бд

  // Разрешенные для записи поля
  protected $fillable = [
    'department_id',
    'name',
    'description'
  ];

}