<?php

namespace App\Controllers;


class Jadwal extends BaseController
{
  function __construct()
  {
    
  }

  public function getAll()
  {
    $data = $this->firestore->getCollection('jadwal');
    $data = json_encode(setDoc($data));
    return $data;
  }

  public function getById($id)
  {
    $data = $this->firestore->getDocument('jadwal', $id);
    
    $jadwal = getField($data->fields->jadwal);
    
    $tanggal = date("Y-m-d", $jadwal);
    $jam = date("H:i:s", $jadwal);

    $res['id'] = $id;
    $res['pesan'] = getField($data->fields->pesan);
    $res['tujuan'] = getField($data->fields->tujuan);
    $res['tanggal'] = $tanggal;
    $res['jam'] = $jam;
    $res['status'] = getField($data->fields->status);

    return json_encode($res);
  }

  function getField($data)
  {
    $res = '';
    $res = $data->stringValue;
    return $res;
  }

  public function add()
  {
    $tanggal = $this->request->getPost('tanggal');
    $jam = $this->request->getPost('jam');

    $string = $tanggal." ".$jam;

    $jadwal = date("Y-m-d H:i", strtotime($string));
    $jadwal = strtotime($jadwal);

    if($jadwal < time()){
      return json_encode([false, "Jadwal mengirim pesan sudah terlewat."]);
    }

    $this->document->setString('pesan', $this->request->getPost('pesan'));
    $this->document->setString('tujuan', $this->request->getPost('tujuan'));
    $this->document->setString('jadwal', "$jadwal");
    $this->document->setString('status', "0");
    $result = $this->firestore->addDocument('jadwal', $this->document);
    
    $result = json_decode($result);

    if(isset($result->error)){
      return json_encode([false, $result->error->message]);
    }else{
      return json_encode([true, "Berhasil Menambah Data"]);
    }
  }

  public function update()
  {
    $id = $this->request->getPost('id');
    $tanggal = $this->request->getPost('tanggal');
    $jam = $this->request->getPost('jam');

    $string = $tanggal." ".$jam;

    $jadwal = date("Y-m-d H:i", strtotime($string));
    $jadwal = strtotime($jadwal);

    if($jadwal < time()){
      return json_encode([false, "Jadwal mengirim pesan sudah terlewat."]);
    }

    $this->document->setString('pesan', $this->request->getPost('pesan'));
    $this->document->setString('tujuan', $this->request->getPost('tujuan'));
    $this->document->setString('jadwal', "$jadwal");
    $this->document->setString('status', "0");
    $result = $this->firestore->updateDocument('jadwal', $id, $this->document);
    
    $result = json_decode($result);

    if(isset($result->error)){
      return json_encode([false, $result->error->message]);
    }else{
      return json_encode([true, "Berhasil Mengubah Data"]);
    }
  }

  public function del($id)
  {
    $result = $this->firestore->deleteDocument('jadwal', $id);

    $result = json_decode($result);

    if(isset($result->error)){
      return json_encode([false, $result->error->message]);
    }else{
      return json_encode([true, "Berhasil Menghapus Data"]);
    }
  }
}