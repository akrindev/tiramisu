<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;

class FbAuth extends Controller
{
  protected $fb;

  public function __construct()
  {
    session()->start();

	$this->fb = new \Facebook\Facebook([
  		'app_id' => env('fb_app_id'),
  		'app_secret' => env('fb_secret_key'),
  		'default_graph_version' => 'v2.10',

	]);
  }

  public function login()
  {
    $helper = $this->fb->getRedirectLoginHelper();

    $permissions = ['email']; // Optional permissions
    $loginUrl = $helper->getLoginUrl('http://localhost:8080/FbAuth/me', $permissions);

    return redirect($loginUrl);
  }

  public function logout()
  {

  }

  public function me()
  {
    $helper = $this->fb->getRedirectLoginHelper();

    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if (! isset($accessToken)) {
      if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
      }
      exit;
    }



    if (! $accessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
      }
    }

    $_SESSION['fb_access_token'] = (string) $accessToken;


    $aku = $this->fb->get('/me?fields=id,name,email,link',$accessToken)->getGraphUser();

    $saya = new User();
    $nyong = $saya->where('fb_id',$aku->getId())->asObject()->first();

    if(!$saya->where('fb_id',$aku->getId())->first())
    {
      return $this->register();
    }


    $sesi = [
      	'namaku' => $nyong->name,
    	'fb_id' => $aku['id'],
		'role'  => $nyong->role,
      	'user'  => true
    ];

    session()->set($sesi);

    return redirect('/')->with('sukses','Selamat datang kembali ' . $nyong->name);
  }


  public function register()
  {
    $gue = $this->fb->get('/me?fields=id,name,email,link',session('fb_access_token'))->getGraphUser();

	$aku = new User();
    $saya = $aku->where('fb_id',$gue->getId())->first();
    $nyong = [
    	'fb_id' => $gue->getId(),
      	'username' => '-',
      	'email' => $gue->getEmail(),
      	'link'	=> $gue->getLink(),
      	'name'	=> $gue->getName(),
    ];

    if($aku->insert($nyong))
    {

    $sesi = [
    	'fb_id' => $aku->fb_id,
		'role'  => $aku->role,
      	'user'  => true,
      	'namaku' => $aku->name
    ];
      session()->set($sesi);
      return redirect('/')->with('sukses','Selamat datang '.$gue->getName());
    }

  }

}