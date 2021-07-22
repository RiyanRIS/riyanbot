<?php

namespace App\Controllers;

use \App\Models\SettingModel;
use \App\Models\FquoteModel;
use \App\Models\FuserModel;

class Mob extends BaseController
{
  public function __construct()
  {
    
  }

  public function index()
  {
    return view("mob/home");
  }

  public function tele()
  {
    $settings = new SettingModel();

		$setting = $settings->findAll();

    $data = [
      "sub" => "Menu Telegram",
      "setting" => $setting
    ];
    return view("mob/tele/index", $data);
  }

  public function users()
  {
    return view("mob/users/index");
  }

  public function quotes()
  {
    $quotes = new FquoteModel();

    $quote = $quotes->getAll();

    $data = [
      "sub" => "Quotes Model",
      "quotes" => $quote
    ];
    return view("mob/quotes/index", $data);
  }


  //--------------------------------------------------------------------

}
