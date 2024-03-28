<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class BookPosts extends Model {

  // Разрешенные для записи поля
  protected $fillable = [
    'department_id',
    'name'
  ];

}