<?php

namespace App\Controllers;

use \App\Models\WaSpamModel;
use \App\Models\SettingModel;
use \App\Models\FuserModel;
use \App\Models\FquoteModel;

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

	public function autoresponn()
	{
		if ($json = json_decode(file_get_contents("php://input"), true)) {
			$data = $json;
		}

		if ($data) {
			$no = $data['msg']['from'];
			$text = $data['msg']['body'];

			// $text = strtolower($text);

			// $text = \explode(" ", $text);

      $this->sendMsg($no, $text);
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
