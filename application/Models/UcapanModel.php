<?php

namespace App\Models;

use CodeIgniter\Model;

class UcapanModel extends Model
{
	protected $table = 'ucapan';
  	protected $allowedFields = [
    	'ucapan','user_id','slug','cover'
    ];

    protected $useTimestamps = true;

  function user_id($id)
  {
  	$userId = $this->builder()->join('users','users.id = ucapan.user_id')
      ->where('user_id',$id)
    	->get()
      ->getResult();

    return $userId[0]->name;
  }


  function getFbIdFromSlug($slug)
  {
  	$userId = $this->builder()->join('users','users.id = ucapan.user_id')
      ->where('slug',$slug)
    	->get()
      ->getResult();

    return $userId[0]->fb_id;
  }
}