<?php

namespace App\Controllers;

include(__DIR__.'/../Libraries/firestore.php');

use PHPFireStore\FireStoreApiClient;
use PHPFireStore\FireStoreDocument;

use CodeIgniter\Controller;

class BaseController extends Controller
{
	protected $session;
	protected $validation;
	protected $helpers = [];

	public $data = [];
	public $nomorku = "6289677249060@c.us";

	// MODEL
	protected $firestore;
	protected $document;
	protected $users;
	protected $kategori;
	protected $tags;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		$this->session       = \Config\Services::session();
		$this->validation = \Config\Services::validation();

		$this->firestore = new FireStoreApiClient(
      'belajarsite-d3728', 'AIzaSyCmCOQ2Aa9mo3Bq-9GeY24OOrPkTlvjA54'
    );
    $this->document = new FireStoreDocument();

		helper(['form', 'ini_helper']);

		// LOAD MODEL
		// $this->users = new UsersModel();
		// $this->kategori = new KategoriModel();
	}

	function savePastebin($text, $name)
	{
		$name ?: time();
		$api_dev_key 			= 'acd7643f900129370d7d3e9d584aff27'; // your api_developer_key
		$api_paste_code 		= $text; // your paste text
		$api_paste_private 		= '1'; // 0=public 1=unlisted 2=private
		$api_paste_name			= $name.'.txt'; // name or title of your paste
		$api_paste_expire_date 		= 'N';
		$api_paste_format 		= 'text';
		$api_user_key 			= '7af152ae1b4fdd014dbbfe0db84df47c'; // if an invalid or expired api_user_key is used, an error will spawn. If no api_user_key is used, a guest paste will be created
		$api_paste_name			= urlencode($api_paste_name);
		$api_paste_code			= urlencode($api_paste_code);

		$url 				= 'https://pastebin.com/api/api_post.php';
		$ch 				= curl_init($url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'api_option=paste&api_user_key='.$api_user_key.'&api_paste_private='.$api_paste_private.'&api_paste_name='.$api_paste_name.'&api_paste_expire_date='.$api_paste_expire_date.'&api_paste_format='.$api_paste_format.'&api_dev_key='.$api_dev_key.'&api_paste_code='.$api_paste_code.'');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 0);

		$response  			= curl_exec($ch);
		return $response;
	}

	function simsimi_curl($text)
	{
		$text = urlencode($text);
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.simsimi.net/v1/?text=$text&lang=id");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		return $result;
	}

	function sendMsg($no, $text)
	{
		if($no == null){
			$no = "15108986398";
		}

		$data = array(
				"number" => $no,
				"message" => $text
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $_SERVER['WA_URL'].'/wa/send');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$headers = array();
		$headers[] = 'Accept: */*';
		$headers[] = 'key: '.$_SERVER['WA_KEY'];
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
	}
}
