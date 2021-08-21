<?php

namespace App\Controllers;

include(__DIR__.'/../Libraries/firestore.php');

use PHPFireStore\FireStoreApiClient;
use PHPFireStore\FireStoreDocument;

use \App\Models\TelUsersModel;
use \App\Models\WaSpamModel;
use \App\Models\SettingModel;
use \App\Models\TelChatModel;
use \App\Models\TelChatStatusModel;
use \App\Models\FquoteModel;

class Schedule extends BaseController
{
  protected $bot;
  protected $bot_token = '1369088735:AAGkBavShqR7Lt3CFfv_QLkvr6S2n45CvBU';
  protected $users;
  protected $chat;
  protected $wa_spam;
  protected $setting;
  protected $quote;
  protected $chat_status;

  public function __construct()
  {
		$this->setting = new SettingModel();
		$this->quote = new FquoteModel();
    $this->users = new TelUsersModel();
    $this->chat = new TelChatModel();
    $this->wa_spam = new WaSpamModel();
    $this->chat_status = new TelChatStatusModel();
    $this->bot = new \Telegram($this->bot_token);
  }

  public function index()
  {
		$setting = $this->setting->findAll();

    // JIKA STATUS SPAM DEACTIVE MAKA KELUAR FUNCTION
    if($setting[0]['statuss'] == 0){
      return true;
    }
		
		$data = $this->quote->getAll();

		$r = \rand(0, (count($data) - 1));
    $pesan = $data[$r]->quote."\n\n~ ".$data[$r]->from;

    $data = $this->users->findAll();
    foreach ($data as $key) {
      $content = ['chat_id' => $key['chatid'], 'text' => $pesan];
      $this->bot->sendMessage($content);
      $this->simpan_pesan($pesan, "kirim", $key['chatid']);
		}
  }

  function whatsapp()
  {
    // CEK JADWAL
    $this->jadwal();

    // KIRIM QUOTES
    $this->kirimQuotes();

  }

  public function jadwal()
  {

    $firestore = new FireStoreApiClient(
      'belajarsite-d3728', 'AIzaSyCmCOQ2Aa9mo3Bq-9GeY24OOrPkTlvjA54'
    );
    $document = new FireStoreDocument();

    $data = $firestore->getCollection('jadwal');
    $data = setDoc($data);

    $a = time()+1200;
    $b = time();

    foreach($data as $key){
      if($b < $key['jadwal'] && $a > $key['jadwal'])
      {
        if($key['status'] == "0"){
          $this->sendMsg($key['tujuan'], $key['pesan']);

          $document->setString('pesan', $key['pesan']);
          $document->setString('tujuan', $key['tujuan']);
          $document->setString('jadwal', $key['jadwal']);
          $document->setString('status', "1");
          $document->setString('waktu_kirim', strval(time()));
          
          $firestore->updateDocument('jadwal', $key['id'], $document);
        }
      }
    }
  }

  public function kirimQuotes()
  {
		$setting = $this->setting->findAll();

    // JIKA STATUS SPAM DEACTIVE MAKA KELUAR FUNCTION
    if($setting[0]['statuss'] == 0){
      return true;
    }

		$data = $this->quote->getAll();

		$r = \rand(0, (count($data) - 1));
    $pesan = $data[$r]->quote."\n\n~ ".$data[$r]->from;

    $this->sendMsg($this->nomorku, $pesan);
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
