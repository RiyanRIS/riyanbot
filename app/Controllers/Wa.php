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
			$no = $data['data']['from'];
			$text = $data['data']['body'];

			$text = strtolower($text);

			$text = \explode(" ", $text);

			if (@$text[0] == 'getno') {
				if(isset($text[1])){
					
					$total = 1000;
					$nomor = $text[1];

					if(isset($text[2])){
						$total = $text[2];
					}

					$pesan = "Oke, crawl untuk no $nomor sebanyak ".$total."x sedang kami proses.";
					$this->sendMsg($no, $pesan);
					$this->getPhoneOrang($text[1], $total);
					die();
				}else{
					$pesan = "Harap gunakan format \"getno [nomor] [perulangan]\"";
					$this->sendMsg($no, $pesan);
					die();
				}
			}

      $this->sendMsg($no, "hai");
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

	public function getPhoneOrang($no, $jum)
	{
		// Starting clock time in seconds
		$start_time = microtime(true);

		$a = $b = 0; $current = "";

		for($i = 1; $i <= $jum; $i++){

			if($i % 100 == 0){ 
				$pesan = "*[INFO]* \n\n$i dari $jum\nDitemukan ".$b." nomor.";
				$this->sendMsg($this->nomorku, $pesan); 
				
				$b = 0;
				sleep(5);
			}

			$no++;

			$data = array(
				"args" => array(
					"contactId" => $no."@c.us",
				)
			);

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://riyanapiwa.herokuapp.com/checkNumberStatus');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

			$headers = array();
			$headers[] = 'Accept: */*';
			$headers[] = 'Api_key: t]z-8Dkyf^nD7iZB9GJI{T$K1[S[s?';
			$headers[] = 'Content-Type: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			try {
				$result = curl_exec($ch);
			} catch (\Throwable $th) {
				//throw $th;
			}

			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}

			curl_close($ch);

			$result = json_decode($result, true);

			if(@$result['response']['canReceiveMessage'] == true && @$result['response']['numberExists'] == true){
				$current .= $no.",".$no.",* myContacts,Mobile,+".$no."\n";
				$a++; $b++;
			}
		}

		$link = $this->savePastebin($current, $no);
			
		// End clock time in seconds
		$end_time = microtime(true);
			
		// Calculate script execution time
		$execution_time = ($end_time - $start_time);

		$pesan = "*Tugas selesai..* \n\nUntuk nomor $no total ditemukan ".$a." nomor dalam waktu ".$execution_time." detik.\nHasil: $link";
		$this->sendMsg($this->nomorku, $pesan);
	}

}
