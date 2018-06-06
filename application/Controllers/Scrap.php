<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Barang;

class Scrap extends Controller
{
  private $ganti = [
  	'/<div class=\"blacksmith\">(.*?)<\/div>/',
  	'/<div class=\"quest\">(.*?)<\/div>/',
  	'/<div class=\"production\">(.*?)<\/div>/',
  ];

  private $prod = [
  	'Metal' => 'Logam',
    'Beast' => 'Fauna',
    'Wood'  => 'Kayu',
	'Cloth' => 'Kain',
    'Medicine' => 'Obat'
  ];

  public function crysta()
  {
    $barang = new \App\Models\Crysta();

    $from = 'http://toram-online.info/items/Gem';

    $item = 'div.Gem';
    $type = 'Gem';

    $typeid = 'Permata';

    $typeslug = url_title(strtolower($type));

        // get contemt from site
    $data = file_get_contents($from);

    //init HTML Dom
    $shd = new Simple_html_dom();

    //load data
    $load = $shd->load($data);

    foreach($load->find($item) as $z)
    {
      $text = $z->plaintext;
    //  echo $text;
      echo "<br><br>";
      $h = explode('[Blacksmith]',$text);

         $judul = explode('['.$type.']',$h[0]);
	$j = $judul[0];
      if(count($h) == 2)
      {
      $judul = explode('['.$type.']',$h[0]);

      $d = explode('Process:',$h[1]);


      }


        $datanya = array(
        	'nama' => $j ?? '-',
          	'slug' => url_title(strtolower($j)),
          	'stats' => $h[1] ?? '-',
          	'type' => $typeid,
          	'typeslug' => $typeslug,
        );

//       $item->nama = $j;
//       $item->slug = url_title(strtolower($j));
//       $item->stats = $desk ?? '-';
//       $item->type = $type;
//       $item->typeslug = $typeslug;
       if($barang->insert($datanya))

       echo "<font color=green>sukses</font>";

      echo "<hr>";
      $desk = '-';
    }

  }


  public function indeuuux()
  {

    $barang = new Barang();


    //inisialisasi link
    $from = 'http://toram-online.info/items/Additional';

    //html inisialisadi
    $item = "div.Additional";

    //nama weapon
    $type = "Additional";
    $types = "Additional";
    $typeslug = url_title(strtolower($type));


    // get contemt from site
    $data = file_get_contents($from);

    //init HTML Dom
    $shd = new Simple_html_dom();

    //load data
    $load = $shd->load($data);

    //looping
    foreach($load->find($item) as $i)
    {
      $text = $i->innertext;

      // blacksmith
      //ngambil info dari class blacksmith
      if(preg_match($this->ganti[0],$text))
      {
        preg_match($this->ganti[0],$text,$match);
        $text = preg_replace($this->ganti[0],' ',$text);

        $match[0] = str_replace('[Blacksmith]','',$match[0]);

        $match[0] = preg_match('/<div(.*?)>(.*?)<\/div>/',$match[0],$ma);

        $blacksmith = $ma[2];
        echo "<font color=red>smith: ". $ma[2]."</font> ";
      }

      //quest
      if(preg_match($this->ganti[1],$text))
      {
        preg_match($this->ganti[1],$text,$match);
        $text = preg_replace($this->ganti[1],' ',$text);
		$match[0] = str_replace('[Quest Item]','',$match[0]);

        $match[0] = preg_match('/<div(.*?)>(.*?)<\/div>/',$match[0],$ma);

        $quest = $ma[2];
        echo "quest: ". $ma[2];
      }

      //prod
      if(preg_match($this->ganti[2],$text))
      {
        preg_match($this->ganti[2],$text,$match);
          $text = preg_replace($this->ganti[2],' ',$text);
        $match[0] = str_replace('[Production]','',$match[0]);

        $match[0] = preg_match('/<div(.*?)>(.*?)<\/div>/',$match[0],$ma);

        $prod = str_replace('Potential','Potensi',$ma[2]);
        echo "prod: ". $prod;
      }


      $teks = explode('Process:',$text);

      $text= str_replace('[Monster Drop]','',$text);

      //proces
      if(count($teks) == 2)
      {
        preg_match('/<a(.*?)>(.*?)<\/a>/',$teks[1],$tek);

        foreach($this->prod as $pr => $pd)
        {
          while(preg_match('/'.$pr.'/',$tek[2]))
          {
            $tek[2] = preg_replace('/'.$pr.'/',$pd,$tek[2]);
          }
        }

        $proses = $tek[2];
        echo $tek[2];
      }

      if(preg_match('/<b><a(.*?)>(.*?)<\/a>/',$text))
      {

        preg_match('/<b><a(.*?)>(.*?)<\/a>/',$text,$m);

        $m[2] = str_replace('['.$types.']','',$m[2]);

        $nama = $m[2];
        echo $m[2];
      }

      $stat = explode('</b>',$text);
      $stats = explode('Process:',$stat[1]);

      $base = $stats[0];
      echo $stats[0];
      //echo $tit;
      //echo "smith ".$match[0];
      $data = [
      	'nama' => $nama ?? '-',
        'slug' => url_title(strtolower($nama)),
        'type' => $type,
        'typeslug' => $typeslug,
        'stats' => $base ?? '-',
        'blacksmith' => $blacksmith ?? '-',
        'quest' => $quest ?? '-',
        'proc' => $proses ?? '-',
        'prod'  => $prod ?? '-'
      ];


    	if($barang->insert($data))
          echo "<font color=green>Successfully inserted</font>";
      print_r($data);
      echo "<hr>";
    }

  }
}