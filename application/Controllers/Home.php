<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Crysta;
use App\Models\Barang;

class Home extends Controller
{
  function __construct(...$params)
  {
    parent::__construct(...$params);
    session()->start();
    helper('form');
  }
	public function index()
	{
      	echo view('header');
		echo view('toram');
      echo view('footer');
	}

  public function barang()
  {
    helper('form');
    echo form_open_multipart('/home/barang');
    echo "<input type='file' name='pics'>";
    echo "<button type='submit'>kirim</button>";
    echo form_close();

    if($a = $this->request->getFile('pics'))
    {
      $a->move(WRITEPATH,'Y');
    }
  }

	//--------------------------------------------------------------------

}