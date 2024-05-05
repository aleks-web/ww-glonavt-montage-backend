<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class OrgContracts extends Model {

  protected $fillable = [
    'organization_id',
    'book_doc_id',
    'contract_num',
    'contract_date_start',
    'contract_date_end',
    'responsible_user_id'
  ];

  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }
}