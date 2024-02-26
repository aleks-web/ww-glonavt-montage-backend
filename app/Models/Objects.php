<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class Objects extends Model {
  protected $fillable = [
    'name',
    'gnum',
    'vin'
  ];

  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }
}