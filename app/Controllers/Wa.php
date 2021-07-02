<?php

namespace App\Controllers;

use \App\Models\WaSpamModel;
use \App\Models\SettingModel;

class Wa extends BaseController
{
	protected $wa_spam;
	protected $setting;

	function savePastebin($text, $name){
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

	public function index(){
		echo "<link id='favicon' rel='icon' type='image/png' href='https://i.ibb.co/BzNVj8K/logo.png'><title>Server Bot WhatsApp 🇮🇩</title>Server Bot WhatsApp 🇮🇩</br></br>❤️ <a target='_blank' href='https://github.com/open-wa/wa-automate-nodejs'>https://github.com/open-wa/wa-automate-nodejs</a></br>🤖 <a target='_blank' href='https://wa.me/16502390040'>https://wa.me/16502390040</a></br></br>Enjoy..😃";
	}

	public function statusSpam()
	{
		helper('form');

		$this->wa_spam = new WaSpamModel();
		$this->setting = new SettingModel();

		$data_wa = $this->wa_spam->findAll();
		$setting = $this->setting->findAll();

		$last = count($data_wa)-1;
		$awal = $data_wa[$last]['no'];

		$str = \file_get_contents("kirim_300621.txt");
		$str = explode(".", $str);
		$total = count($str);

		echo "<h2>Status Spam Whatsapp</h2>Pesan tersampaikan: <b>".$awal." pesan</b> dari total ".$total." pesan<br><br>";

		if($setting[0]['statuss'] == 1){
			echo form_open(\uri_string());
			echo form_hidden('statuss', '0');
			echo "\nStatus: 🟢Active... ";
			echo form_submit('submit', 'Nonaktifkan');
			echo form_close();
		}else{
			echo form_open(\uri_string());
			echo form_hidden('statuss', '1');
			echo "\nStatus: 🔴Deactive... ";
			echo form_submit('submit', 'Aktifkan');
			echo form_close();
		}

	}

	public function getStatusSpam()
	{
		$this->setting = new SettingModel();

		$data = ['statuss' => $this->request->getPost("statuss")];
		if($this->setting->update('1', $data)){
			return redirect()->to(site_url("wa/cek"));
		}else{
			echo "Something went wrong...";
		}

	}

	public function getPhoneOrang($no, $jum){
		// Starting clock time in seconds
		$start_time = microtime(true);

		$a = $b = 0; $current = "";

		for($i = 1; $i <= $jum; $i++){

			if($i % 100 == 0){ 
				$pesan = "*[INFO]* \n\n$i dari $jum\nDitemukan ".$b." nomor.";
				$this->sendMsg("6289677249060@c.us", $pesan); 
				
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
		$this->sendMsg("6289677249060@c.us", $pesan);
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

			if ($text[0] == 'getno') {
				if(isset($text[1])){
					
					$total = 1000;
					$nomor = $text[1];

					if(isset($text[2])){
						$total = $text[2];
						$pesan = "Oke, crawl untuk no $nomor sebanyak ".$total."x sedang kami proses.";
						$this->sendMsg($no, $pesan);
					}else{
						$pesan = "Oke, crawl untuk no $nomor sebanyak ".$total."x sedang kami proses.";
						$this->sendMsg($no, $pesan);
					}
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

	function sendMsg($no, $text)
	{
		$data = array(
			"args" => array(
				"to" => $no,
				"content" => $text
			)
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://riyanapiwa.herokuapp.com/sendText');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$headers = array();
		$headers[] = 'Accept: */*';
		$headers[] = 'Api_key: t]z-8Dkyf^nD7iZB9GJI{T$K1[S[s?';
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
	}

	
}
