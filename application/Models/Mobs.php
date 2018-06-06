<?php

namespace App\Models;

use CodeIgniter\Model;

class Mobs extends Model
{
  protected $table = 'mobs';
  protected $allowedFields = [
  	'nama', 'slug',
    'xp', 'hp',
    'level', 'type',
    'element', 'pics',
    'map', 'kandang',
    'drop_items','drop_equip',
    'notes', 'mapslug'
  ];

  protected $useTimestamps = true;

}