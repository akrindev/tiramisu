<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UcapanModel as Ucap;
use App\Models\User;

class Ucapan extends Controller
{

 function __construct(...$args)
 {
   parent::__construct(...$args);

   session()->start();
   helper('form');

 }
  function lihat($slug)
  {
    if(!$slug)
    {
      return redirect('/');
    }

    $ucap = new Ucap;


    if(!$ucap->where('slug',$slug)->first())
    {

      return redirect('/')->with('gagal','Konten tidak di temukan atau sudah di hapus');
    }

    $ucapan = $ucap->where('slug',$slug)->asObject()->first();


    $userName = $ucap->user_id($ucapan->user_id);

    echo view('header',[
    	'title' => 'Ucapan spesial dari '. $userName
    ]);
    echo view('ucapan/lihat',[
    	'cover' => $ucapan->cover,
    	'ucapan' => $ucapan->ucapan,
      	'oleh'  => $userName
    ]);
    echo view('footer');
  }

  function buat()
  {

   if(!session('user'))
   {
     return redirect('/')->with('gagal','Login di butuhkan');
   }
    echo view('header',[
    	'title' => 'Buat ucapan spesial ke temen'
    ]);
    echo view('ucapan/buat.php');
    echo view('footer');
  }

  function submit()
  {
    if(!session('user')) return redirect('/');
    $user = new User;
    $ucap = new Ucap;

    $userId = $user->where('fb_id',session('fb_id'))->asObject()->first();

    $img = ['jpg','jpeg','png'];

    $ucapan = $this->request->getPost('ucapan');
    $cover = $this->request->getFile('cover');

    $coverRandName = $cover->getRandomName();
    $coverImg = '-';

    if($cover->move('img/ucapan/',$coverRandName))
    {
      $coverImg = 'img/ucapan/'.$coverRandName;
    }

    $slugE = explode('.',$coverRandName);
    $slug = substr($slugE[0],18);

    $data = [
        'user_id' => $userId->id,
    	'ucapan' => $ucapan,
      	'cover' => $coverImg,
      	'slug' => $slug
    ];

    if($ucap->insert($data))
    {
      return redirect('/ucapan/lihat/'.$slug)->with('sukses','Ucapan berhasil di buat');;
    }
  }

  function edit($slug)
  {
    if(!$slug) return redirect('/');

    $ucap = new Ucap;

    if(!$ucap->where('slug',$slug)->first())
    {
      return redirect('/')->with('gagal','Tautan salah atau mungkin telah di hapus');
    }

    $post = $ucap->where('slug',$slug)->asObject()->first();
    $me = $ucap->getFbIdFromSlug($slug);

    if(!session('user') && session('fb_id') != $me)
    {
      return redirect('/')->with('gagal','Anda tidak memiliki izin untuk mengedit');
    }

    echo view('header',[
    	'title' => 'Edit Ucapan'
    ]);
    echo view('ucapan/edit',[
      'ucapan' => $post->ucapan,
      'cover' => $post->cover,
      'id' => $post->id
    ]);
    echo view('footer');
  }

  function editSubmit()
  {
    $ucap = new Ucap;

    //$file = $this->request->getFiles();


    $ucapan = $this->request->getPost('ucapan');

    $data = [
    	'ucapan' => $ucapan,
    ];

    if(!empty($_FILES['cover']['name']))
    {
      $file = $this->request->getFile('cover');
      $name = $file->getRandomName() ?? sha1(rand(00,99)).'png';
      $file->move('img/ucapan/',$name);
      $dataCover = [
      	'cover' => 'img/ucapan/'.$name
      ];

      $data = array_merge($data,$dataCover);
    }

    $r = explode('/',$this->request->getPost('redir'));
    $r = end($r);
    if($ucap->update($this->request->getPost('id'),$data))
    {
      return redirect('/ucapan/lihat/'.$r);
    }

  }


  function delete($slug)
  {

    if(!$slug) return redirect('/');

    $ucap = new Ucap;

    if(!$ucap->where('slug',$slug)->first())
    {
      return redirect('/')->with('gagal','Tautan salah atau mungkin telah di hapus');
    }

    $post = $ucap->where('slug',$slug)->asObject()->first();
    $me = $ucap->getFbIdFromSlug($slug);

    if(!session('user') && session('fb_id') != $me)
    {
      return redirect('/')->with('gagal','Anda tidak memiliki izin untuk menghapus');
    }

    if($ucap->delete($post->id))
    {
      return redirect('/')->with('sukses','Ucapan pribadi di hapus');
    }
  }


}