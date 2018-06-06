<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Crysta;

class CrystaController extends Controller
{
  function __construct(...$params)
  {
    parent::__construct(...$params);

    session()->start();
    helper('form');
  }

  public function crystas($slug=false)
  {
    if($slug == false)
    {
      return redirect('/');
    }

    $crysta = new Crysta();

    $crystal = $crysta->asObject()->findWhere('typeslug',$slug);

    if(is_null($crystal))
    {
      return redirect('/');
    }

    echo view('header',[
    	'title' => $crystal[0]->type
    ]);
    echo view('crysta/crysta',[
    	'data' => $crystal
    ]);
    echo view('footer');
  }

  public function crysta($slug=false)
  {
    if($slug == false)
    {
      return redirect('/');
    }

    $crysta = new Crysta();

    $crystal = $crysta->asObject()->findWhere('slug',$slug);

    if(is_null($crystal))
    {
      return redirect('/');
    }


    echo view('header',[
    	'title' => $crystal[0]->nama
    ]);
    echo view('crysta/crysta',[
    	'data' => $crystal
    ]);
    echo view('footer');
  }


  /*
  * untuk menampilkan halaman edit equip
  */
  public function editCrysta($id)
  {
    $this->needLogin();

    $item = new Crysta();

    $data = $item->asObject()->find($id);

    if(is_null($data))
    {
      return redirect('/');
    }

    echo view('header');
    echo view('crysta/edit_crysta',[
      'data' =>$data,
      'errors' => service('validation')
    ]);
    echo view('footer');
  }

  public function editCrystaPost($id)
  {

    $this->needLogin();

    $item = new Crysta();

    $data = $item->asObject()->find($id);

    if(is_null($data))
    {
      return redirect('/');
    }

    if(! $this->validate([
    	'nama' => 'required|trim',
      	'type' => 'required',
      	'stats' => 'trim',
 		'slug' => 'trim'
    ]))
    {
      $this->editCrysta($id);
    }


    $result = [
      'nama' => $this->request->getPost('nama'),
      'slug' => $this->request->getPost('slug') ?? url_title(strtolower($this->request->getPost('nama'))),
      'type' => $this->request->getPost('type'),
      'stats' => $this->request->getPost('stats') ?? '-'
    ];

    if($item->update($id,$result))
    {
      return redirect()->back()->with('upsukses','updated');
    }
  }

  public function deleteCrysta($id)
  {
    $this->needLogin();

    $item = new Crysta();

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

  public function storeCrysta()
  {
    $this->needLogin();
    echo view('header');
    echo view('crysta/add_crysta',[
    	'errors' => service('validation')
    ]);
    echo view('footer');
  }
  public function storeCrystaPost()
  {

    $this->needLogin();

    $item = new Crysta();


    if(! $this->validate([
    	'nama' => 'required|trim',
      	'type' => 'required',
      	'slug' => 'trim',
      	'stats' => 'trim'
    ]))
    {
      return $this->storeCrysta();
    }

    $post = [
    	'nama' => esc($this->request->getPost('nama')),
      	'type' => esc($this->request->getPost('type')),
      	'stats' => esc($this->request->getPost('stats'))
    ];

    $po = [
      'slug' => url_title(strtolower($this->request->getPost('nama'))),

      'typeslug' => url_title(strtolower($this->request->getPost('type')))
    ];
    $result = array_merge($post,$po);

    if($item->insert($result))
    {
      return redirect('/')->with('sukses','Data crysta telah ditambahkan!!');
    }
  }

  private function needLogin()
  {
    if(!session('user') && session('role') == 'member')
    {
      return redirect('/')->with('sukses','Tidak diijinkan');
    }
  }
}