<?php

namespace WWCrm\Models;

class BookServices extends \Illuminate\Database\Eloquent\Model {

  public $timestamps = false; // Отключаем даты в бд

  // Разрешенные для записи поля
  protected $fillable = [
    'name',
    'description'
  ];

}