<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
  protected $table = 'users';
  protected $allowedFields = [
  	'username','fb_id','link','name','email'
  ];
  protected $useTimestamps = true;
  public $usr;

  function getUserId($fbid)
  {
    $aku = $this->builder()->where('fb_id',$fbid)->get()->getResult();

    return $aku[0]->id;
  }
}