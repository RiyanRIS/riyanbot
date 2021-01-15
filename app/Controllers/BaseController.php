<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class BaseController extends Controller
{
	protected $session;
	protected $validation;
	protected $helpers = [];

	// MODEL
	protected $users;
	protected $kategori;
	protected $tags;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		$this->session       = \Config\Services::session();
		$this->validation = \Config\Services::validation();

		// LOAD MODEL
		$this->users = new UsersModel();
		$this->kategori = new KategoriModel();
	}

}
