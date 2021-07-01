<?php

namespace Config;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Bot');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Bot::index');
$routes->get('/bot', 'Bot::index');
$routes->post('/bot', 'Bot::bot');

$routes->add('/wa', 'Wa::index');
$routes->get('/wa/cek', 'Wa::statusSpam');
$routes->post('/wa/cek', 'Wa::getStatusSpam');

$routes->get('/carinomor', 'Wa::getPhoneOrang');
$routes->post('/wa/autoresponse', 'Wa::autoresponn');
// $routes->get('/tes', 'Home::sendMsg');
$routes->get('/tes/(:any)/(:any)', 'Wa::sendMsg/$1/$2');

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
