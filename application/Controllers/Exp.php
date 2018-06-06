<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Exp extends Controller
{
  function __construct(...$p)
  {
    parent::__construct(...$p);

    session()->start();
    helper('form');
  }

  function index()
  {
    echo view('header',[
    	'title' => 'Exp Calculator'
    ]);
    echo view('xp_calculator');
    echo view('footer');
  }
}