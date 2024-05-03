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

  // Департаменты 
  public function department()
  {
      return $this->belongsTo('\WWCrm\Models\BookDepartments', 'department_id', 'id');
  }

  /*
    Получает пользователей принадлежащих к этому объекту
  */
  public function users() {
    return $this->hasMany('\WWCrm\Models\Users', 'post_id', 'id');
  }

}