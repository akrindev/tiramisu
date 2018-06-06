<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Barang;

class EquipController extends Controller
{

  function __construct(...$params)
  {
    parent::__construct(...$params);
    session()->start();
    helper('form');
  }

  /**
  * Menampilkan item dari kategory type
  * banyak
  **/
  public function equips($slug=false)
  {
    if($slug == false)
      return redirect('/');

    $items = new Barang();

    $kunci = $items->asObject()->findWhere('typeslug',$slug);

    if(!$kunci)
    {
      return redirect('/');
    }


    echo view('header',[
    	'title' => $kunci[0]->type
    ]);
    echo view('equip/equip',[
    	'data' => $kunci
    ]);
    echo view('footer');
  }

  /**
  * Menampilkan item
  * 1 equip
  **/
  public function equip($slug=false)
  {
    if($slug == false)
      return redirect('/');

    $item = new Barang();

    $kunci = $item->asObject()->findWhere('slug',$slug);

    if(!$kunci)
    {
      return redirect('/');
    }

    echo view('header',[
    	'title' => $kunci[0]->nama
    ]);
    echo view('equip/equip',[
    	'data' => $kunci
    ]);
    echo view('footer');
  }


  /*
  * untuk menampilkan halaman edit equip
  */
  public function editEquip($id)
  {
    $this->needLogin();

    $item = new Barang();

    $data = $item->asObject()->find($id);

    if(!$data)
    {
      return redirect('/');
    }

    echo view('header');
    echo view('equip/edit_equip',[
      'data' =>$data,
      'errors' => service('validation')
    ]);
    echo view('footer');
  }

  public function editEquipPost($id)
  {

    $this->needLogin();

    $item = new Barang();

    $data = $item->asObject()->find($id);

    if(is_null($data))
    {
      return redirect('/');
    }

    if(! $this->validate([
    	'nama' => 'required|trim',
      	'type' => 'required',
      	'pics' => 'trim',
      	'stats' => 'trim',
      	'drop' => 'trim',
      	'blacksmith' => 'trim',
      	'proc' => 'trim',
      	'prod' => 'trim'
    ]))
    {
      $this->editEquip($id);
    }


    if($this->request->getPost('gantipics') == 'ya')
    {
      //unlink('/imgs/'.url_title(strtolower($this->request->getPost('nama'))).'.png');
      $pics = $this->pics();
    }

 	$post = [
    	'nama' => esc($this->request->getPost('nama')),
      	'type' => esc($this->request->getPost('type')),
      	'pics' => $pics ?? '',
      	'stats' => esc($this->request->getPost('stats')),
      	'drop' => esc($this->request->getPost('drop')),
      	'blacksmith' => esc($this->request->getPost('blacksmith')),
      	'proc' =>  esc($this->request->getPost('proc')),
      	'prod' => esc($this->request->getPost('prod'))
    ];

    $po = [
      'slug' => url_title(strtolower($this->request->getPost('nama')))
    ];
    $result = array_merge($post,$po);

    if($item->update($id,$result))
    {
      return redirect('/equip/'.url_title(strtolower($this->request->getPost('nama'))) ?? $data->slug)->with('upsukses','updated');
    }
  }

  public function deleteEquip($id)
  {

    $this->needLogin();

    $item = new Barang();

    $data = $item->asObject()->find($id);

    if(is_null($data))
    {
      return redirect('/');
    }

    if($item->delete($id))
    {
      return redirect('/')->with('sukses','data equip telah di hapus');
    }
  }

  public function storeEquip()
  {

    $this->needLogin();

    echo view('header');
    echo view('equip/add_equip',[
    	'errors' => service('validation')
    ]);
    echo view('footer');
  }
  public function storeEquipPost()
  {

    $this->needLogin();
    $item = new Barang();


    if(! $this->validate([
    	'nama' => 'required|trim',
      	'type' => 'required',
      	'pics' => 'trim',
      	'stats' => 'trim',
      	'drop' => 'trim',
      	'blacksmith' => 'trim',
      	'proc' => 'trim',
      	'prod' => 'trim'
    ]))
    {
      return $this->storeEquip();
    }


    if($this->request->getPost('pics'))
    {
      $pics = $this->pics();
    }

    $post = [
    	'nama' => esc($this->request->getPost('nama')),
      	'type' => esc($this->request->getPost('type')),
      	'pics' => $pics ?? '',
      	'stats' => esc($this->request->getPost('stats')),
      	'drop' => esc($this->request->getPost('drop')),
      	'blacksmith' => esc($this->request->getPost('blacksmith')),
      	'proc' =>  esc($this->request->getPost('proc')),
      	'prod' => esc($this->request->getPost('prod'))
    ];

    $po = [
      'slug' => url_title(strtolower($this->request->getPost('nama'))),

      'typeslug' => url_title(strtolower($this->request->getPost('type')))
    ];
    $result = array_merge($post,$po);


    if($item->insert($result))
    {
      return redirect('/')->with('sukses','Data equip telah ditambahkan!!');
    }
  }

  private function pics()
  {
    $urlimg = file_get_contents($this->request->getPost('pics'));
    $nama = 'imgs/'.url_title(strtolower($this->request->getPost('nama'))).'.png';

    file_put_contents($nama,$urlimg);


    service('image')
        ->withFile($nama)
        ->text('(c) toram-id.info', [
            'color'      => 'ffffff',
            'opacity'    => 0.3,
            'withShadow' => true,
            'hAlign'     => 'left',
            'vAlign'     => 'bottom',
            'fontSize'   => 18
        ])
        ->save($nama);

    return $nama;
  }

  private function needLogin()
  {
    if(!session('user') && session('role') == 'member')
    {
      return redirect('/')->with('sukses','Tidak diijinkan');
    }
  }
}