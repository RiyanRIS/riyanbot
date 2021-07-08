<?php

namespace App\Controllers;

use \App\Models\FquoteModel;

class WaQuote extends BaseController
{
	protected $f_quote;

  public function __construct()
  {
    $this->f_quote = new FquoteModel();
  }

	public function index(){
		$data['nav'] = 'quote'; 
		$data['title'] = 'Quote Model'; 
		return view("wa/quote", $data);
	}

	public function getAdd(){
		$data = [
			'quote' => $this->request->getPost('quote'),
			'from' => $this->request->getPost('from'),
		];
		$result = $this->f_quote->add($data);
		return json_encode($result);
	}

	public function getGet($id){
		$result = $this->f_quote->get($id);
		return json_encode($result);
	}

	public function getUpd(){
		$id = $this->request->getPost('id');
		$data = [
			'quote' => $this->request->getPost('quote'),
			'from' => $this->request->getPost('from'),
		];
		$result = $this->f_quote->upd($id, $data);
		return json_encode($result);
	}

	public function getDel($id){
		$result = $this->f_quote->del($id);
		return json_encode($result);
	}

}
