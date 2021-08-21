<?php

namespace App\Controllers;

use \App\Models\WaSpamModel;
use \App\Models\SettingModel;
use \App\Models\FuserModel;
use \App\Models\FquoteModel;

use function GuzzleHttp\json_decode;

class Wa extends BaseController
{
	protected $wa_spam;
	protected $setting;
	protected $f_user;

	public function index()
	{
		$this->setting = new SettingModel();

		$setting = $this->setting->findAll();

		$data['nav'] = 'home'; 
		$data['setting'] = $setting;
		return view("wa/index", $data);
	}

	public function jadwal($kode = null, $id = null)
	{
		if($kode==null){
			$data['nav'] = 'jadwal'; 
			return view("wa/jadwal", $data);
		}
	}

	public function autoresponn()
	{
		if ($json = json_decode(file_get_contents("php://input"), true)) {
			$data = $json;
		}

		if ($data) {
			$no = $data['msg']['from'];
			$text = $data['msg']['body'];

			// Simi bales chat
			$result = $this->simsimi_curl($text);
			$result = \json_decode($result);
			$jawaban_simi = $result->success;

      $this->sendMsg($no, $jawaban_simi);
		}
	}

	public function getStatus()
	{
		$this->setting = new SettingModel();

		$data = ['statuss' => $this->request->getPost("statuss")];
		if($this->setting->update('1', $data)){
			return redirect()->to(base_url("wa"));
		}else{
			echo "Something went wrong...";
		}

	}

}
