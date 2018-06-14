<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(BASEPATH.'Config/Routes.php'))
{
	require BASEPATH.'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
$routes->discoverLocal(false);

$routes->add('/', 'Home::index');
$routes->post('/cari','CariController::cari');

$routes->get('/equip/(:any)','EquipController::equip/$1');
$routes->get('/equips/(:any)','EquipController::equips/$1');

$routes->get('/crystas/(:any)','CrystaController::crystas/$1');
$routes->get('/crysta/(:any)','CrystaController::crysta/$1');

$routes->get('/peta/(:any)','MobsController::peta/$1');
$routes->get('/monster','MobsController::index');
$routes->get('/monster/(:any)','MobsController::single/$1');

$routes->get('/edit/(:num)/crysta','CrystaController::editCrysta/$1');
$routes->post('/edit/(:num)/crysta','CrystaController::editCrystaPost/$1');
$routes->get('/edit/(:num)/crysta/delete','CrystaController::deleteCrysta/$1');

// crud equip
$routes->get('/store-equip','EquipController::storeEquip');
$routes->post('/store-equip','EquipController::storeEquipPost');


$routes->get('/store-crysta','CrystaController::storeCrysta');
$routes->post('/store-crysta','CrystaController::storeCrystaPost');


$routes->get('/monster','MobsController::index');
$routes->get('/store-mob','MobsController::add');
$routes->post('/store-mob','MobsController::addPost');


$routes->get('/edit/(:num)/mobs','MobsController::edit/$1');
$routes->post('/edit/(:num)/mobs','MobsController::editPost/$1');
$routes->get('/edit/(:num)/mobs/delete','MobsController::delete/$1');


$routes->get('/edit/(:num)/equip','EquipController::editEquip/$1');
$routes->post('/edit/(:num)/equip','EquipController::editEquipPost/$1');
$routes->get('/edit/(:num)/equip/delete','EquipController::deleteEquip/$1');

// digunakan untuk sistem login
$routes->get('/loginAdmin','UserController::login');
$routes->post('/loginAdmin','UserController::loginPost');

//sistem register
$routes->get('/register','UserController::register');
$routes->post('/register','UserController::registerPost');


//lohout
$routes->get('/logout','UserController::logout');




/** fill stats router **/
$routes->get('/fill_stats','FillstatsController::index');

$routes->get('/fill_stats/add','FillstatsController::add');
$routes->get('/fill_stats/(:any)','FillstatsController::single/$1');
$routes->get('/fill_stats/(:any)/(:num)','FillstatsController::single/$1/$2');


$routes->post('/fill_stats/add','FillstatsController::adding');

$routes->get('/edit/(:num)/fillstats','FillstatsController::edit/$1');
$routes->post('/edit/(:num)/fillstats','FillstatsController::editing/$1');

$routes->get('/delete/(:num)/fillstats','FillstatsController::delete/$1');

$routes->get('/fb-login','FbAuth::login');


//ucapan
$routes->get('/ucapan/buat','Ucapan::buat');
$routes->post('/ucapan/buat','Ucapan::submit');


// profile
$routes->get('/u','UserController::profile');
$routes->get('/u/(:num)','UserController::profile/$1');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH.'Config/'.ENVIRONMENT.'/Routes.php'))
{
	require APPPATH.'Config/'.ENVIRONMENT.'/Routes.php';
}