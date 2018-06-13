<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;

class UserController extends Controller
{

  protected $category;

  public function __construct(...$params)
  {
    parent::__construct(...$params);

    session()->start();
    helper('form');
  }

  public function profile($nama = false)
  {
    $nyong = new User;

    $aku = $nyong->where('fb_id',session('fb_id'))->first();

    if($nama = false)
    {
      $aku = $nyong->where('fb_id',$nama)->first();
    }

    if(!$aku)
    {
      return redirect('/')->with('error','Member tidak ditemukan');
    }

    $poto = "https://graph.facebook.com/{$aku['fb_id']}/picture?type=normal";
    $nama = $aku['name'];


    echo view('header',[
    	'title' => 'Profile ' . $aku['name']
    ]);
    echo view('profile',[
    	'poto' => $poto,
    	'nama'	=> $nama
    ]);
    echo view('footer');

  }

  // ---- logout ---- ///

  public function logout()
  {
    session()->destroy();
    session()->start();
    session()->regenerate(true);
    return redirect('/');
  }

}