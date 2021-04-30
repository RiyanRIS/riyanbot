<?php

namespace App\Models;

use CodeIgniter\Model;

class TelUsersModel extends Model
{
    protected $table = 'tel_users';
    protected $primaryKey = 'chatid';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['chatid', 'name', 'username', 'lastUpdate'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
