<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;
use App\Models\UcapanModel as Ucap;

class UserController extends Controller
{

  protected $category;

  public function __construct(...$params)
  {
    parent::__construct(...$params);

    session()->start();
    helper(['form','tanggal']);
  }

  public function profile($nama = false)
  {

    if( ! session('user'))
      return redirect('/')->with('gagal','Kamu harus login terlebih dahulu');

    $nyong = new User;

    $aku = $nyong->where('fb_id',session('fb_id'))->first();

   $ucapan = new Ucap;

    $ucap = $ucapan->where('user_id',$nyong->getUserId(session('fb_id')))->orderBy('created_at','DESC')->get()->getResult();

    if($nama != false)
    {
      $aku = $nyong->where('fb_id',$nama)->first();
      $ucap = [];
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
    	'nama'	=> $nama,
      	'ucap' => $ucap
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