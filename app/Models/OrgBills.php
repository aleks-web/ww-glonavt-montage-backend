<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class OrgBills extends Model {

  protected $fillable = [
    'contract_id',
    'bill_file_name',
    'sum',
    'comment'
  ];

  // возвращает fillable
  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }

}