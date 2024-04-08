<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class Users extends Model {

  public $timestamps = false;

  protected $fillable = [
    'name',
    'surname',
    'patronymic',
    'tel',
    'email',
    'birth',
    'password'
  ];
}