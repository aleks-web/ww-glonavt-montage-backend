<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class Article extends Model {
  protected $fillable = ["title", "description", "user_id"];

  public function user() {
    return $this->belongsTo('WWCrm\Models\User');
  }
}