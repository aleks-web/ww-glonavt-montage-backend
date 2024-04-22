<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class Users extends Model {

  public $timestamps = false;

  protected $fillable = [
    'name',
    'surname',
    'patronymic',
    'post_id',
    'tel',
    'email',
    'birth',
    'password'
  ];

  // Должность
  public function post()
  {
      return $this->belongsTo('\WWCrm\Models\BookPosts', 'post_id', 'id');
  }
}