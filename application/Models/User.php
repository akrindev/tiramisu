<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
  protected $table = 'users';
  protected $allowedFields = [
  	'username','email','password'
  ];
  protected $useTimestamps = true;
  public $usr;

  public function login($username,$pw)
  {
    // get user info
    $user = $this->where('username',$username)
      			->where('active',1)
      			->get()
      			->getResultArray();

    // if user not found
    if(!$user)
    {
      return false;
    }

    $usr = new \stdClass;
    foreach($user as $u)
    {
      $usr->id		 = $u['id'];
      $usr->user	 = $u['username'];
      $usr->password = $u['password'];
      $usr->role	 = $u['role'];
    }

    $this->usr = $usr;

    // if user was found lets just verify the password
    if(password_verify($pw,$usr->password))
    {
      if(! isset($_SESSION))
      {
        session()->start();
      }

      session()->set('user', $usr->id);
      session()->set('role', $usr->role);
      return true;
    }

    return false;
  }

  public function register($data)
  {
    // get info user
    $user = $this->findWhere('username',$data['username']);

    // if there is no user found
    if(!$user)
    {
      // store into database
        $this->insert([
          'username' => $data['username'],
          'email' => $data['email'],
          'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

      return true;
    }

    return false;
  }
}