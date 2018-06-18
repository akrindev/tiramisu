<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ForumController extends Controller
{
  function index()
  {
    session()->start();

    echo view('header');
    echo view('forum/p');
    echo view('footer');
  }
}