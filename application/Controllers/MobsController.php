<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Mobs;


class MobsController extends Controller
{

  function __construct(...$p)
  {
    parent::__construct(...$p);

    helper('form');
    session()->start();
  }

  public function index()
  {
    $mobs = new Mobs();

    echo view('header',[
      'title' => 'Daftar Monster'
    ]);
    echo view('monster/mobs',[
    	'data' => $mobs->asObject()->findAll()
    ]);
    echo view('footer');
  }

  public function single($slug)
  {
    $mobs = new Mobs();
    $mons = $mobs->asObject()->findWhere('slug',$slug);

    if(!$mons)
    {
      return redirect('/');
    }

    echo view('header',[
      'title' => $mons[0]->nama
    ]);
    echo view('monster/mobs',[
    	'data' => $mons
    ]);
    echo view('footer');
  }

  public function peta($slug)
  {
    $mobs = new Mobs();
    $mons = $mobs->asObject()->findWhere('mapslug',$slug);

    if(!$mons)
    {
      return redirect('/');
    }

    echo view('header',[
      'title' => $mons[0]->map
    ]);
    echo view('monster/mobs',[
    	'data' => $mons,
      	'dut' => 'ok'
    ]);
    echo view('footer');
  }

  public function add()
  {
    $this->needLogin();

    echo view('header');
    echo view('monster/add_mobs');
    echo view('footer');
  }

  public function addPost()
  {
    $this->needLogin();

    $mobs = new Mobs();

    $req = $this->request;

    $data = [
    	'nama' => esc(ucfirst($req->getPost('nama'))),
    	'slug' => url_title(strtolower($req->getPost('nama'))).'-'.rand(000,999),
    	'type' => esc($req->getPost('type')),
    	'element' => esc($req->getPost('element')),
    	'hp' => esc($req->getPost('hp')),
    	'xp' => esc($req->getPost('xp')),
    	'level' => esc($req->getPost('level')),
    	'map' => esc($req->getPost('map')),
      	'mapslug' => url_title(strtolower($req->getPost('map'))),
    	'kandang' => esc($req->getPost('kandang')),
    	'drop_items' => esc($req->getPost('drop_items')),
    	'drop_equip' => esc($req->getPost('drop_equip')),
    	'notes' => esc($req->getPost('notes'))
    ];


    if($req->getPost('withimg') == "ya")
    {
        $pics = $this->pics();
		$dataa = [ 'pics' => $pics ];
		$data = array_merge($data,$dataa);
    }


    if($mobs->insert($data))
    {
		return redirect('/')->with('sukses','Data Monster telah di tambahkan');
    }

  }

  public function edit($id)
  {
    $this->needLogin();

    $mobs = new Mobs();

    $mons = $mobs->find($id);

    if(!$mons)
    {
      return redirect('/');
    }

    echo view('header');
    echo view('monster/edit_mobs',$mons);
    echo view('footer');

  }

  public function editPost($id)
  {

    $this->needLogin();
    $mobs = new Mobs();
    $req = $this->request;

    $mons = $mobs->asObject()->find($id);

    if(!$mons)
    {
      return redirect('/');
    }


    $data = [
    	'nama' => esc(ucfirst($req->getPost('nama'))),
    	'type' => esc($req->getPost('type')),
    	'element' => esc($req->getPost('element')),
    	'hp' => esc($req->getPost('hp')),
    	'xp' => esc($req->getPost('xp')),
    	'level' => esc($req->getPost('level')),
    	'map' => esc($req->getPost('map')),
      	'mapslug' => url_title(strtolower($req->getPost('map'))),
    	'kandang' => esc($req->getPost('kandang')),
    	'drop_items' => esc($req->getPost('drop_items')),
    	'drop_equip' => esc($req->getPost('drop_equip')),
    	'notes' => esc($req->getPost('notes'))
    ];

    if($req->getPost('withimg') == "ya")
    {
		$pics = $this->pics();
		$dataa = [ 'pics' => $pics ];
		$data = array_merge($data,$dataa);
    }


    if($mobs->update($id,$data))
    {
      return redirect('/monster')->with('sukses','Data Monster telah di ubah');
    }
  }

  public function delete($id)
  {

    $this->needLogin();

    $item = new Mobs();

    $data = $item->asObject()->find($id);

    if(!$data)
    {
      return redirect('/');
    }

    if($item->delete($id))
    {
      return redirect('/')->with('sukses','data monster telah di hapus');
    }
  }

  private function pics()
  {
    $urlimg = file_get_contents($this->request->getPost('pics'));
    $nama = 'imgs/mobs/'.url_title(strtolower($this->request->getPost('nama'))).'-'.rand(00000,99999).'.png';

    file_put_contents($nama,$urlimg);


    service('image')
        ->withFile($nama)
        ->text('(c) toram-id.info', [
            'color'      => 'ffffff',
            'opacity'    => 0.5,
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