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

$routes->get('/wa', 'Home::index');
$routes->post('/wa', 'Home::index');
// $routes->get('/tes', 'Home::sendMsg');
$routes->get('/tes/(:any)/(:any)', 'Home::sendMsg/$1/$2');


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
