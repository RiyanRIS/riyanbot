<?php

namespace App\Models;

use CodeIgniter\Model;

class TelChatStatusModel extends Model
{
  protected $table = 'tel_statuschat';
  protected $primaryKey = 'id';

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;

  protected $allowedFields = ['id', 'chatid', 'nama', 'status'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  function ada($chatid)
  {
    return $this->where("chatid", $chatid)
      ->where("status", 0)
      ->orderBy('id', 'DESC')
      ->findAll();
  }
}
