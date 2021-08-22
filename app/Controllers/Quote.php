<?php

namespace App\Controllers;

class Quote extends BaseController
{
  private $collection_name = "quote";
  function __construct(){}

  public function index(){
		$data['nav'] = 'quote'; 
		$data['title'] = 'Quote Model'; 
		return view("wa/quote", $data);
	}

  public function getAll()
  {
    $data = $this->firestore->getCollection($this->collection_name);
    $data = json_encode($this->toArrayQuote($data));
    return $data;
  }

  public function getById($id)
  {
    $data = $this->firestore->getDocument($this->collection_name, $id);
    
    $res['id'] = $id;
    $res['from'] = getField($data->fields->from);
    $res['quote'] = getField($data->fields->quote);

    return json_encode($res);
  }

  public function add()
  {
    $this->document->setString('quote', $this->request->getPost('quote'));
    $this->document->setString('from', $this->request->getPost('from'));
    $result = $this->firestore->addDocument($this->collection_name, $this->document);
    
    $result = json_decode($result);

    if(isset($result->error)){
      return json_encode([false, $result->error->message]);
    }else{
      return json_encode([true, "Berhasil Menambah Data"]);
    }
  }

  public function update()
  {
    $id = $this->request->getPost("id");

    $this->document->setString('from', $this->request->getPost('from'));
    $this->document->setString('quote', $this->request->getPost('quote'));
    $result = $this->firestore->updateDocument($this->collection_name, $id, $this->document);
    
    $result = json_decode($result);

    if(isset($result->error)){
      return json_encode([false, $result->error->message]);
    }else{
      return json_encode([true, "Berhasil Mengubah Data"]);
    }
  }

  public function del($id)
  {
    $result = $this->firestore->deleteDocument($this->collection_name, $id);

    $result = json_decode($result);

    if(isset($result->error)){
      return json_encode([false, $result->error->message]);
    }else{
      return json_encode([true, "Berhasil Menghapus Data"]);
    }
  }

  public function toArrayQuote($data)
  {
    $res = []; $no = 0;

    if(!isset($data->documents)){
      return $res;
    }

    // JIKA COLLECTION KOSONG
    if(count($data->documents) == 0){
      return $res;
    }

    foreach ($data->documents as $key) {
      $res[$no]['id'] = getId($key->name);
      $fields = $key->fields;
      $res[$no]['from'] = getField($fields->from);
      $res[$no]['quote'] = getField($fields->quote);
      $no++;
    }

    return $res;
  }
}