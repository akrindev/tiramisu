<?php

namespace App\Models;

use CodeIgniter\Model;

class Fillstats extends Model
{
  protected $table = 'fill_stats';
  protected $allowedFields = [
    'type',
    'plus',
    'stats',
    'steps'
  ];

  protected $useTimestamps = true;

}