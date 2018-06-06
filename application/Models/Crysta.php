<?php

namespace App\Models;

use CodeIgniter\Model;

class Crysta extends Model
{
  protected $table = 'crystas';
  protected $allowedFields = [
  	'nama','slug','stats','type','typeslug'
  ];

  protected $useSoftDeletes = true;
}