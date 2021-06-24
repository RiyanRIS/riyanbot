<?php

namespace App\Controllers;

class Wa extends BaseController
{

	public function index(){
    
		if($_POST){
      $notujuan = $_POST['notujuan']."@c.us";
      $this->sendMsg($notujuan, $_POST['pesan']);
    }

    return view("wa/index");
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
