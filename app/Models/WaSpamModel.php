<?php

namespace App\Models;

use CodeIgniter\Model;

class WaSpamModel extends Model
{
  protected $table = 'wa_spam';
  protected $primaryKey = 'id';

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;

  protected $allowedFields = ['id', 'no', 'wkt_mulai', 'lamanya'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
