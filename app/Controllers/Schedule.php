<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use \App\Models\TelUsersModel;
use \App\Models\TelChatModel;
use \App\Models\TelChatStatusModel;

class Schedule extends Controller
{
  protected $bot;
  protected $bot_token = '1369088735:AAGkBavShqR7Lt3CFfv_QLkvr6S2n45CvBU';
  protected $users;
  protected $chat;
  protected $chat_status;

  public function __construct()
  {
    $this->users = new TelUsersModel();
    $this->chat = new TelChatModel();
    $this->chat_status = new TelChatStatusModel();
    $this->bot = new \Telegram($this->bot_token);
  }

  public function index()
  {
    $str = file_get_contents('https://raw.githubusercontent.com/lakuapik/quotes-indonesia/master/raw/quotes.json');
		$json = json_decode($str, true); // decode the JSON into an associative array

		$r = rand(1,306);
    $pesan = $json[$r]['quote']."\n\n~ ".$json[$r]['by'];

    $data = $this->users->findAll();
    foreach ($data as $key) {
      $content = ['chat_id' => $key['chatid'], 'text' => $pesan];
      $this->bot->sendMessage($content);
      $this->simpan_pesan($pesan, "kirim", $key['chatid']);
    }
  }

  function whatsapp()
  {
    $str = file_get_contents('https://raw.githubusercontent.com/lakuapik/quotes-indonesia/master/raw/quotes.json');
		$json = json_decode($str, true); // decode the JSON into an associative array

		$r = rand(1,306);
    $pesan = $json[$r]['quote']."\n\n~ ".$json[$r]['by'];
    
    $data = array(
      "args" => array(
        "to" => "6289677249060@c.us",
        "content" => $pesan
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

  function simpan_pesan($pesan, $status = 'kirim', $chatid = false)
  {
    $data = [
      'pesan' => $pesan,
      'status' => $status,
      'createAt' => time(),
      'chatid' => ($chatid ?: $this->bot->ChatID())
    ];
    $this->chat->insert($data);
  }
}
