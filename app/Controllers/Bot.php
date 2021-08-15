<?php

namespace App\Controllers;
// ruwet
use \App\Models\TelUsersModel;
use \App\Models\TelChatModel;
use \App\Models\TelChatStatusModel;

class Bot extends BaseController
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
    return "sayang";
  }

  public function bot()
  {
    $chatid = $this->bot->ChatID();
    $text = $this->bot->Text();

    $this->simpan_pesan($text, 'terima');
    $this->cek_pengguna();

    $ada_status = $this->chat_status->ada($chatid);
    if (count($ada_status) > 0) {
      $nama_status = $ada_status[0]['nama'];
      $id_status = $ada_status[0]['id'];
    }

    if (!empty($nama_status) && !empty($text)) {
      if ($nama_status == "masukkan nama") {
        $pesan = "Baik, $text adalah nama kamu..";
        $content = ['chat_id' => $chatid, 'text' => $pesan];
        $this->bot->sendMessage($content);

        $this->simpan_pesan($pesan);

        $this->perbarui_statuschat($id_status);

        $pesan = "Sekarang, masukkan usia kamu..";
        $content = ['chat_id' => $chatid, 'text' => $pesan];
        $this->bot->sendMessage($content);
        $this->simpan_pesan($pesan);
        $this->buat_statuschat("masukkan usia");

        die();
      }

      if ($nama_status == "masukkan usia") {
        $pesan = "Terima kasih, kami sudah mencatat usia kamu.";
        $content = ['chat_id' => $chatid, 'text' => $pesan];
        $this->bot->sendMessage($content);

        $this->simpan_pesan($pesan);

        $pesan = "Gunakan data berikut untuk masuk. \nusername: " . rand(100000, 999999) . "\npassword: " . rand(1000, 9999);
        $content = ['chat_id' => $chatid, 'text' => $pesan];
        $this->bot->sendMessage($content);

        $this->perbarui_statuschat($id_status);

        die();
      }
    }

    if (!is_null($text)) {
      if ($text == '/daftar') {
        $pesan = "Baiklah, pertama-tama kami butuh nama kamu..";
        $content = ['chat_id' => $chatid, 'text' => $pesan];
        $this->bot->sendMessage($content);
        $this->simpan_pesan($pesan);

        $pesan = "Silahkan masukkan nama kamu";
        $content = ['chat_id' => $chatid, 'text' => $pesan];
        $this->bot->sendMessage($content);
        $this->simpan_pesan($pesan);

        $this->buat_statuschat("masukkan nama");

        die();
      }

      if ($text == '/test') {
        $pesan = "Pesan telah kami terima";
        $content = ['chat_id' => $chatid, 'text' => $pesan];
        $this->bot->sendMessage($content);
        $this->simpan_pesan($pesan);
        die();
      }

      $pesan = "Maaf, kami tidak paham maksut kamu.\nGunakan \help untuk melihat bantuan.";
      $content = ['chat_id' => $chatid, 'text' => $pesan];
      $this->bot->sendMessage($content);
      $this->simpan_pesan($pesan);
    }
  }

  function cek_pengguna()
  {
    $cek = $this->users->where('chatid', $this->bot->ChatID())->findAll();

    if (count($cek) > 0) {
      $data = [
        'username' => $this->bot->Username(),
        'name' => $this->bot->FirstName() . " " . $this->bot->LastName(),
        'lastUpdate' => date("Y-m-d"),
      ];
      $this->users->update($this->bot->ChatID(), $data);
    } else {
      $data = [
        'username' => $this->bot->Username(),
        'name' => $this->bot->FirstName() . " " . $this->bot->LastName(),
        'create_at' => time(),
        'chatid' => $this->bot->ChatID()
      ];
      $this->users->insert($data);
    }
  }

  function buat_statuschat($nama)
  {
    $data = [
      "chatid" => $this->bot->ChatID(),
      "nama" => $nama,
      "status" => 0
    ];
    $this->chat_status->insert($data);
  }

  function perbarui_statuschat($id_status)
  {
    $data = [
      "status" => 1
    ];
    $this->chat_status->update($id_status, $data);
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

  //--------------------------------------------------------------------

}
