<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class BookDepartments extends Model {

  // Разрешенные для записи поля
  protected $fillable = [
    'name',
    'description'
  ];

}