<?php
// Telegram function which you can call
function telegram($msg)
{
  global $telegrambot, $telegramchatid;
  $url = 'https://api.telegram.org/bot' . $telegrambot . '/sendMessage';
  $data = array('chat_id' => $telegramchatid, 'text' => $msg);
  $options = array('http' => array('method' => 'POST', 'header' => "Content-Type:application/x-www-form-urlencoded\r\n", 'content' => http_build_query($data),),);
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  return $result;
}

// Set your Bot ID and Chat ID.
$telegrambot = '1369088735:AAGkBavShqR7Lt3CFfv_QLkvr6S2n45CvBU';
$telegramchatid = 780207093;

date_default_timezone_set("Asia/Jakarta");
$text = "Ini adalah pukul " . date("H:i") . "WIB";
// Function call with your own text or variable
telegram($text);
