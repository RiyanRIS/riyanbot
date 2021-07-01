<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
  protected $table = 'setting';
  protected $primaryKey = 'id';

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;

  protected $allowedFields = ['id', 'nama', 'statuss'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
