<?php

namespace App\Models;

use CodeIgniter\Model;

class Barang extends Model
{
  protected $table = 'barangs';
  protected $allowedFields = [
    'nama',
    'stats',
    'pics',
    'proc',
    'prod',
    'blacksmith',
    'quest',
    'type',
    'slug',
    'typeslug'
  ];

  protected $useSoftDeletes = true;
  protected $useTimestamps = true;
}