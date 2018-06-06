<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;

class UserController extends Controller
{

  protected $category;

  public function __construct(...$params)
  {
    parent::__construct(...$params);

    session()->start();
  }

  // ---- login function ---- //
  public function login()
  {
    if(session('user'))
      return redirect('/');

    helper('form');

    echo view('header');
    echo view('login',[
    	'errors' => service('validation')
    ]);
    echo view('footer');
  }

  public function loginPost()
  {

    if(session('user'))
      return redirect('/');
    if(! $this->validate([
    	'username' => 'required',
      	'password' => 'required|min_length[6]'
    ]))
    {
   		return $this->login();
    }

    $userModel = new User;
    $login = $userModel->login(
    	$this->request->getPost('username'),
      	$this->request->getPost('password')
    );

    if($login === false)
    {
      return redirect()->back()->withInput()
        		->with('fail','username or password didnt match or account has not activated yet');
    }

      return redirect('/');
  }

  // ---- end of login function ---- //


  // --- register function ---- //

  public function register()
  {

    if(session('user'))
      return redirect('/');

    helper('form');

    echo view('header');
    echo view('register',[
    	'errors' => service('validation')
    ]);
    echo view('footer');
  }

  public function registerPost()
  {

    if(session('user'))
      return redirect('/');

    if(! $this->validate([
      	'username'			=> 'required',
    	'email'			=> 'required|valid_email',
      	'password' 		=> 'required|min_length[6]',
      	'conf-password' => 'required|matches[password]'
    ]))
    {
      return $this->register();
    }

    $user = new User;
    $data = [
      	'username' => $this->request->getPost('username'),
    	'email' => $this->request->getPost('email'),
      	'password' => $this->request->getPost('password')
    ];

    if($user->register($data))
    {
      return redirect('login')->withInput()
        		->with('success','you are here now, lets have a session');
    }

    return $this->register();
  }

    // ---- end of register function ---- //

  // ---- logout ---- ///

  public function logout()
  {
    session()->destroy();
    session()->start();
    session()->regenerate(true);
    return redirect('/');
  }

}