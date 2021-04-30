<?php

namespace App\Models;

use CodeIgniter\Model;

class TelChatModel extends Model
{
  protected $table = 'tel_chat';
  protected $primaryKey = 'id';

  protected $returnType     = 'array';
  protected $useSoftDeletes = false;

  protected $allowedFields = ['id', 'chatid', 'pesan', 'createAt', 'status'];

  protected $validationRules    = [];
  protected $validationMessages = [];
  protected $skipValidation     = false;
}
