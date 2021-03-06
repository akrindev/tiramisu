<?php
use App\Models\Barang;
use App\Models\Crysta;

$item = new Barang();
$crysta = new Crysta();
helper('url');
?>

<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Toram <?=$title ?? 'Online Database Indonesia';?></title>


<meta property="og:url"                content="<?=current_url(true);?>" />
<meta property="og:type"               content="article" />
<meta content='Toram Online Indonesia' property='og:site_name'/>
<meta property="og:title"              content="<?=$title ?? 'Online Database Indonesia';?>" />
<meta property="og:description"        content="<?=$deskripsi ?? 'Toram online Database bahasa indonesia, items, weapon, armor, monster, etc';?> " />
<meta property="og:image"              content="http://toram-id.info/img/logo.gif" />
<meta property="fb:app_id" content="2008283499456981"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="/assets/js/require.min.js"></script>
    <script>
      requirejs.config({
          baseUrl: 'http://toram-id.info'
      });
    </script>
    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Dashboard Core -->
    <link href="/assets/css/dashboard.css" rel="stylesheet" />
    <script src="/assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="/assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="/assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="/assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="/assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="/assets/plugins/input-mask/plugin.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109854426-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109854426-3');
</script>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-6056470544527952",
    enable_page_level_ads: true
  });
</script>

  </head>
  <body class="">
    <div class="page">
      <div class="page-main">
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="/">
                <img src="/img/potum.gif" class="header-brand-img" alt="Toram-id.info logo"> Toram-id.info
              </a>
              <div class="d-flex order-lg-2 ml-auto">
<?php if(!session('user')): ?>
 				<div class="nav-item d-md-flex">
                   <a href="/fb-login" class="btn btn-sm btn-outline-primary">Login with FB</a>
                 </div>
 <?php else: ?>
               <div class="nav-item d-md-flex">

                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(https://graph.facebook.com/<?=session('fb_id')?>/picture?type=normal"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?=session('namaku')?></span>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="/u">
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#" onClick="alert('under development')">
                      <i class="dropdown-icon fe fe-settings"></i> Settings
                    </a>
                    <a class="dropdown-item" href="/ucapan/buat">

                     <i class="dropdown-icon fe fe-mail"></i> Tulis Ucapan
                    </a>
                    <a class="dropdown-item" href="#" onClick="alert('under development')">
                      <i class="dropdown-icon fe fe-send"></i> Message
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onClick="alert('under development')">
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>
                    <a class="dropdown-item" href="/logout">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                  </div>
                </div>
              </div>
<?php endif; ?>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">

              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="/" class="nav-link"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-box"></i> Perlengkapan</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                           <?php
       $a = $item->select('type,typeslug')->distinct()->get()->getResult();

        foreach($a as $b):
        ?>
                      <a href="/equips/<?=$b->typeslug;?>" class="dropdown-item "><?=$b->type?></a>

                      <?php endforeach;?>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-star"></i> Crysta</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <?php
       $c = $crysta->select('type,typeslug')->distinct()->get()->getResult();

        foreach($c as $d):
        ?>
                      <a href="/crystas/<?=$d->typeslug;?>" class="dropdown-item "><?=$d->type?></a>

                      <?php endforeach;?>

                    </div>
                  </li>

<li class="nav-item">
                    <a href="/monster" class="nav-link"><i class="fe fe-github"></i> Monster</a>
                  </li>
                  <li class="nav-item">
                    <a href="/exp" class="nav-link"><i class="fe fe-bar-chart"></i> Exp calculator</a>
                  </li>

                  <li class="nav-item">
                    <a href="/fill_stats" class="nav-link"><i class="fe fe-edit-2"></i> Fill stats formula</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>