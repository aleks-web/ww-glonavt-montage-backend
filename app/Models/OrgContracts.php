<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class OrgContracts extends Model {

  protected $fillable = [
    'organization_id',
    'contract_file_name',
    'book_doc_id',
    'contract_num',
    'contract_date_start',
    'contract_date_end',
    'responsible_user_id'
  ];

  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }

  public function responsibleUser() {
    return $this->belongsTo('\WWCrm\Models\Users', 'responsible_user_id', 'id');
  }

  public function docType() {
    return $this->belongsTo('\WWCrm\Models\BookDocs', 'book_doc_id', 'id');
  }
}