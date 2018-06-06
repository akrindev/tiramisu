<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Fillstats as Fill;

class FillstatsController extends Controller
{
  public function __construct(...$args)
  {
    parent::__construct(...$args);
    session()->start();

    helper('form');
  }

  function index()
  {

    $fill = new Fill();
    $getFill = $fill->orderBy('plus','ASC')->orderBy('type','ASC')->get()->getResult();

    echo view('header',[
    	'title' => 'Fill stats Formula',
    'deskripsi' => 'Toram Fill stats Formula full stats full step work 100%'
    ]);
    echo view('fillstats/home',[
    	'data' => $getFill
    ]);
    echo view('footer');

  }

  function single($type,$plus=false)
  {
    $fill = new Fill();
    $tipe = $type == 'Armor' ? 1 : 2;

    if($plus == false){
    	$data = $fill->where('type',$tipe)->orderBy('plus','ASC')->get()->getResult();
    } else {
    	$data = $fill->where('type',$tipe)->where('plus',$plus)->orderBy('type','ASC')->orderBy('plus','ASC')->get()->getResult();
    }

    echo view('header',[
    	'title' => $type.' Fill stats Formula'
    ]);
    echo view('fillstats/home',[
    	'data' => $data
    ]);
    echo view('footer');
  }

  function add()
  {

    $this->needLogin();

    echo view('header',[
    	'title' => 'Fill stats Formula'
    ]);
    echo view('fillstats/add',['errors'=>service('validation')]);
    echo view('footer');

  }

  function adding()
  {

    $this->needLogin();
    if(! $this->validate([
    	'type' => 'required|trim',
      	'plus' => 'required',
      	'stats' => 'required|trim',
      	'steps' => 'required|trim'
    ]))
    {
      return $this->add();
    }

    $fill = new Fill();
    if($fill->insert($this->request->getPost()))
    {
      return redirect()->back()->with('sukses','data telah di tambahkan');
    }
  }

  function edit($id)
  {

    $this->needLogin();
    $fill = new Fill();
    $data = $fill->asObject()->find($id);

    if(!$data)
    {
      return redirect('/');
    }

    echo view('header',[
    	'title' => 'Edit data'
    ]);
    echo view('fillstats/edit',[
    	'data' => $data,
    	'errors' => service('validation')
    ]);
    echo view('footer');
  }

  function editing($id)
  {

    $this->needLogin();
    $fill = new Fill();
    $data = $fill->asObject()->find($id);

    if(!$data)
    {
      return redirect('/');
    }

    if(! $this->validate([
    	'type' => 'required|trim',
      	'plus' => 'required',
      	'stats' => 'required|trim',
      	'steps' => 'required|trim'
    ]))
    {
      return $this->edit($id);
    }

    if($fill->update($id,$this->request->getPost()))
    {
      return redirect()->back()->with('sukses','Data berhasil di ubah');
    }

  }

  function delete($id)
  {

    $this->needLogin();
    $fill = new Fill();
    $data = $fill->asObject()->find($id);

    if(!$data)
    {
      return redirect('/');
    }

    if($fill->delete($id))
    {
      return redirect('/')->with('sukses','Data berhasil di hapus');
    }
  }

  private function needLogin()
  {
    if(!session('user') && session('role') == 'user')
    {
      return redirect('/')->with('sukses','Tidak diijinkan');
    }
  }
}