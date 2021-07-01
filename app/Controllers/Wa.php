<?php

namespace App\Controllers;

use \App\Models\WaSpamModel;

class Wa extends BaseController
{
	protected $wa_spam;

	public function index(){
		echo "<link id='favicon' rel='icon' type='image/png' href='https://i.ibb.co/BzNVj8K/logo.png'><title>Server Bot WhatsApp 🇮🇩</title>Server Bot WhatsApp 🇮🇩</br></br>❤️ <a target='_blank' href='https://github.com/open-wa/wa-automate-nodejs'>https://github.com/open-wa/wa-automate-nodejs</a></br>🤖 <a target='_blank' href='https://wa.me/13156967238'>https://wa.me/13156967238</a></br></br>Enjoy..😃";
  
	}

	public function getPhoneOrang(){
		// Starting clock time in seconds
		$start_time = microtime(true);

		$no = 628981530000; $res = array();
		for($i = 1; $i <= 590; $i++){
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

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);

			$result = json_decode($result, true);

			if($result['response']['canReceiveMessage'] == true && $result['response']['numberExists'] == true){
				$file = 'phone.txt';
				$current = file_get_contents($file);
				$current .= $no.",".$no.",* myContacts,Mobile,".$no."\n";
				file_put_contents($file, $current);
			}
		}
			
		// End clock time in seconds
		$end_time = microtime(true);
			
		// Calculate script execution time
		$execution_time = ($end_time - $start_time);
			
		echo "<pre>\n\nExecution time of script = ".$execution_time." sec\n\n";
		echo "done...</pre>";
	}

	public function autoresponn()
	{
		if ($json = json_decode(file_get_contents("php://input"), true)) {
			$data = $json;
		}

		if ($data) {
			$no = $data['data']['from'];
			$text = $data['data']['body'];

			$file = 'log.txt';
			$current = file_get_contents($file);
			$current .= time() . "\t" . $no . "\t" . $text .  "\n";
			file_put_contents($file, $current);

			if ($text == '/daftar') {
				$pesan = "Baiklah, pertama-tama kami butuh nama kamu..";
				$this->sendMsg($no, $pesan);

				$pesan = "Silahkan masukkan nama kamu";
				$this->sendMsg($no, $pesan);
				die();
			}

			if ($text == '/test') {
				$pesan = "Pesan telah kami terima";
				$this->sendMsg($no, $pesan);
				die();
			}

			// $pesan = "Maaf, kami tidak paham maksut kamu.\nGunakan \help untuk melihat bantuan.";
			$url = "https://fdciabdul.tech/api/ayla/?pesan=".urlencode($text);

      $response = file_get_contents($url);
      $response = json_decode($response);

      $this->sendMsg($no, $response->jawab);
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
