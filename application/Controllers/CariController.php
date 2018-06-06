<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CariController extends Controller
{
  function __construct(...$params)
  {
    parent::__construct(...$params);

    session()->start();

    helper('form');
  }

  public function cari()
  {
    $key = $this->request->getPost('key');
    $type = $this->request->getPost('type');

    if($type == 'perlengkapan')
    {
      return $this->cariPerlengkapan($key);
    } else {
      return $this->cariCrysta($key);
    }
  }

  private function cariPerlengkapan($key)
  {
    $barang = new \App\Models\Barang();

    $f = $barang->like('nama',$key)->get()->getResult();

    if(is_null($f))
    {
      return redirect()->back()->with('sukses','Tidak ditemukan');
    }

    echo view('header');
    echo view('equip/equip',[
    	'data' => $f
    ]);
    echo view('footer');
  }


  private function cariCrysta($key)
  {
    $barang = new \App\Models\Crysta();

    $f = $barang->like('nama',$key)->get()->getResult();

    if(is_null($f))
    {
      return redirect()->back()->with('sukses','Tidak ditemukan');
    }

    echo view('header');
    echo view('crysta/crysta',[
    	'data' => $f
    ]);
    echo view('footer');
  }
}