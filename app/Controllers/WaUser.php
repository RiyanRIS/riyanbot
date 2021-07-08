<?php

namespace App\Controllers;

use \App\Models\FuserModel;

class WaUser extends BaseController
{
	protected $f_user;

  public function __construct()
  {
    $this->f_user = new FuserModel();
  }

	public function index(){
		$data['nav'] = 'user'; 
		$data['title'] = 'User Model'; 
		return view("wa/user", $data);
	}

	public function getAdd(){
		$data = [
			'nama' => $this->request->getPost('nama'),
			'nohp' => $this->request->getPost('nohp'),
			'alamat' => $this->request->getPost('alamat')
		];
		$result = $this->f_user->add($data);
		return json_encode($result);
	}

	public function getGet($id){
		$result = $this->f_user->get($id);
		return json_encode($result);
	}

	public function getUpd(){
		$id = $this->request->getPost('id');
		$data = [
			'nama' => $this->request->getPost('nama'),
			'nohp' => $this->request->getPost('nohp'),
			'alamat' => $this->request->getPost('alamat')
		];
		$result = $this->f_user->upd($id, $data);
		return json_encode($result);
	}

	public function getDel($id){
		$result = $this->f_user->del($id);
		return json_encode($result);
	}

}
