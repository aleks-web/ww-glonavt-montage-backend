<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class User extends Model {
  protected $fillable = ["name", "surname"];

  public function articles() {
    return $this->hasMany('WWCrm\Models\Article', 'user_id', 'id');
  }
}