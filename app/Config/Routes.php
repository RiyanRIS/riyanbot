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

$routes->get('/wa/home', 'Wa::home');

$routes->group('wa/user', function($routes)
{
	$routes->get('/', 'WaUser::index');
	$routes->post('add', 'WaUser::getAdd');
	$routes->post('get/(:any)', 'WaUser::getGet/$1');
	$routes->post('upd', 'WaUser::getUpd');
	$routes->post('del/(:any)', 'WaUser::getDel/$1');
});

$routes->group('wa/quote', function($routes)
{
	$routes->get('/', 'WaQuote::index');
	$routes->post('add', 'WaQuote::getAdd');
	$routes->post('get/(:any)', 'WaQuote::getGet/$1');
	$routes->post('upd', 'WaQuote::getUpd');
	$routes->post('del/(:any)', 'WaQuote::getDel/$1');
});

$routes->get('/wa/cek', 'Wa::statusSpam');
$routes->post('/wa/cek', 'Wa::getStatusSpam');

$routes->post('/wa/autoresponse', 'Wa::autoresponn');

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
