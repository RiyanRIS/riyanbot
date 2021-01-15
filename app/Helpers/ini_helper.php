<?php

// use App\Models\UsersModel;

function nav($a,$b){
    if($a == $b){
        echo "active";
    }
}

function nav1($a,$b){
    if($a == $b){
        echo "menu-open";
    }
}

function slugify($text){
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

function isActive(){
    $user = new UsersModel();
    $user = $user->getUsers(session()->get('id'));
    if($user[0]['status_email'] != NULL){
        return true;
    }else{
        return false;
    }
}

function toRp($val){
    return "Rp " . number_format($val,0,',','.');
}

function toUrl($nama,$jenis){
    return base_url("assets/img/".$jenis."/".$nama);
}

function breadcump($title,$breadcump,$desc = null){
    echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>'.
        $title.'
        <small>'.@$desc.'</small>
      </h1>
      <ol class="breadcrumb">';
      if(count($breadcump) == 1){ ?>
        <li><a href="javascript:void()"><i class="fa fa-dashboard"></i> <?= $breadcump[0] ?></a></li>
     <?php }elseif(count($breadcump) == 2){ ?>
        <li><a href="javascript:void()"><i class="fa fa-dashboard"></i> <?= $breadcump[0] ?></a></li>
        <li class="active"><?= $breadcump[1] ?></li>
     <?php }elseif(count($breadcump) == 3){ ?>
        <li><a href="javascript:void()"><i class="fa fa-dashboard"></i> <?= $breadcump[0] ?></a></li>
        <li><a href="javascript:void()"><?= $breadcump[1] ?></a></li>
        <li class="active"><?= $breadcump[2] ?></li>
     <?php }else{ ?>
        <li><a href="javascript:void()"><i class="fa fa-dashboard"></i> <?= $breadcump[0] ?></a></li>
        <li><a href="javascript:void()"><?= $breadcump[1] ?></a></li>
        <li><a href="javascript:void()"><?= $breadcump[2] ?></a></li>
        <li class="active"><?= $breadcump[3] ?></li>
    <?php }
    echo '
      </ol>
    </section>';
}

// https://base64.guru/developers/php/examples/base64url
function base64url_encode($data){
    $b64 = base64_encode($data);
    if ($b64 === false) {
        return false;
    }
    $url = strtr($b64, '+/', '-_');
    return rtrim($url, '=');
}

    
function base64url_decode($data, $strict = false){
    $b64 = strtr($data, '-_', '+/');
    return base64_decode($b64, $strict);
}