<?php namespace Config;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Home::index');

// CONTOH ROUTER
$routes->group('home', function ($routes) {
	$routes->get('dashboard', 'Home::dashboard');
	$routes->add('profile', 'Home::profile');
	$routes->get('n/(:any)', 'Home::notifikasi/$1');

	$routes->group('pengguna', function ($routes) {
		$routes->get('/', 'Pengguna::index');
		$routes->add('tambah', 'Pengguna::tambah');
		$routes->add('ubah/(:num)', 'Pengguna::ubah/$1');
		$routes->get('aktifkan/(:num)', 'Pengguna::act/1/$1');
		$routes->get('nonaktifkan/(:num)', 'Pengguna::act/0/$1');
		$routes->get('hapus/(:num)', 'Pengguna::hapus/$1');
	});

});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
