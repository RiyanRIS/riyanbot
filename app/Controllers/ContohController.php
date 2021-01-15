<?php namespace App\Controllers;

class ContohController extends BaseController{
	
	public function __construct(){}

	public function index(){
        $artikel = null;
		if (!$this->ionAuth->loggedIn()){
			return redirect()->to(site_url('/auth/login'))->with('msg', [0,lang("Msg.belumlogin")]);
		}else if ($this->ionAuth->inGroup([1,3])){
            $artikel = $this->artikel->getArtikel();
		}else{
			$artikel = $this->artikel->getArtikelByUser($this->session->get('user_id'));
        }
        $data = [
            'title' => "Data Artikel",
            'breadcump' => ['Home','Artikel'],
            'nav' => 3,
			'artikel' => $artikel,
			'ingroup' => $this->ionAuth->inGroup([1,3]),
		];
		$data['notif'] = $this->notifikasi->getNotifikasi();
        return view('home/artikel/index',$data);
	}

	public function tambah(){
		if (!$this->ionAuth->loggedIn()){
			return redirect()->to(site_url('/auth/login'))->with('msg', [0,lang("Msg.belumlogin")]);
		}else{
			$this->validation->setRule('judul', "Judul", 'trim|required|max_length[300]');
			$this->validation->setRule('kategori', "Kategori", 'trim|required|integer');
			$this->validation->setRule('konten', "Konten", 'trim|required');
			$this->validation->setRule('tags', "Tags", 'required');

			if($this->request->getFile('gambar')){
				$this->validation->setRule('gambar', "Gambar", 'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]|max_size[gambar,2048]');
			}

			if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()){
				$tags = $this->request->getPost('tags');

				$photo = $this->request->getFile('gambar');
				if(!empty($photo->getName())){
					$newimg = $photo->getRandomName();
					$photo->move(ROOTPATH . 'public/assets/img/artikel/', $newimg);
					$image = \Config\Services::image()
						->withFile(ROOTPATH . 'public/assets/img/artikel/'.$newimg)
						->resize(450, 250, FALSE)
						->save(ROOTPATH . 'public/assets/img/artikel/'.$newimg, 90);
					$photo = $newimg;
				}

				$status = 'draft';

				$slug = slugify($this->request->getPost('judul'));
				$insertData = [
					'kategori' => (int)$this->request->getPost('kategori'),
					'judul' => $this->request->getPost('judul'),
					'konten' => $this->request->getPost('konten'),
					'gambar' => $photo,
					'status' => $status,
					'penulis' => (int)$this->session->get('user_id'),
					'slug'  => $slug,
				];
				$insertid = $this->artikel->simpan($insertData);
				if($insertid){
					$this->tagartikel->reset($insertid);
					foreach ($tags as $tag) {
						($this->tags->cekTags($tag) ?: $this->addTags($tag)); // JIKA TAG BELUM ADA MAKA MASUKIN KE TABLE TAGS
						$tagData = [
							'tag' => $tag,
							'berita' => $insertid,
						];
						$insert = $this->tagartikel->simpan($tagData);
						if(!$insert){
							return redirect()->back()->withInput()->with('msg', [0,lang('Msg.gagal_mengubah_artikel')]);
						}
					}
					$this->log("insert",$insertid,"artikel");
					if($this->ionAuth->inGroup([1,3])){
						return redirect()->to(site_url('/home/artikel'))->with('msg', [1,lang('Msg.berhasil_mempublish_artikel')]);
					}
					return redirect()->to(site_url('/home/artikel'))->with('msg', [1,lang('Msg.berhasil_menambah_artikel')]);
					
				}else{
					return redirect()->back()->withInput()->with('msg', [0,lang('Msg.gagal_menambah_artikel')]);
				}
			}else{
				$data = [
					'title' => "Tambah Artikel",
					'breadcump' => ['Home','Artikel','Tambah Artikel'],
					'nav' => 3,
				];
				
				$data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : "";

				$data['judul'] = [
					'name'  => 'judul',
					'id'    => 'judul',
					'type'  => 'text',
					'class' => 'form-control',
					'required' => true,
					'autofocus' => true,
					'placeholder' => 'Judul Artikel',
					'value' => set_value('judul'),
                ];
                
				$kategori = null; $kategories = $this->kategori->getKategori();
				foreach($kategories as $item) $kategori[$item['id']] = $item['kategori'];
				
				$data['kategori'] = ['kategori',$kategori,null,'class="form-control" required="true"'];
				
				$tag = null; $tags = $this->tags->getTags();
				foreach($tags as $item) $tag[$item['tags']] = $item['tags'];
				$data['tags'] = ['tags[]',$tag,[],'class="form-control select2" multiple="multiple" data-placeholder="Select a Tags"
				style="width: 100%;" required="true"','tags'];

                $data['gambar'] = [
					'name'  => 'gambar',
					'id'    => 'gambar',
					'placeholder' => 'Gambar Sampul',
					'keterangan' => 'max size 2 mb, 450 x 700 px',
					'value' => set_value('gambar'),
                ];
				$data['notif'] = $this->notifikasi->getNotifikasi();
				return view('home/artikel/tambah',$data);
			}
		}
	}

	public function ubah(int $id){
		if (!$this->ionAuth->loggedIn()){
			return redirect()->to(site_url('/auth/login'))->with('msg', [0,lang("Msg.belumlogin")]);
		}else{
			$artikel = $this->artikel->getArtikel($id);
			if(count($artikel)==0){
				return redirect()->back()->with('msg', [0,"Gagal memuat artikel, mungkih sudah dihapus."]);
			}

			$this->validation->setRule('judul', "Judul", 'trim|required|max_length[300]');
			$this->validation->setRule('kategori', "Kategori", 'trim|required|integer');
			$this->validation->setRule('tags', "Tags", 'required');
			$this->validation->setRule('konten', "Konten", 'trim|required');

			if($this->request->getFile('gambar')){
				$this->validation->setRule('gambar', "Gambar", 'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]|max_size[gambar,2048]');
			}

			if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()){
				$tags = $this->request->getPost('tags');

				$imglama = $this->request->getPost('imglama');
				$photo = $this->request->getFile('gambar');
				if(!empty($photo->getName())){
					$newimg = $photo->getRandomName();
					$photo->move(ROOTPATH . 'public/assets/img/artikel/', $newimg);
					$image = \Config\Services::image()
						->withFile(ROOTPATH . 'public/assets/img/artikel/'.$newimg)
						->resize(450, 250, FALSE)
						->save(ROOTPATH . 'public/assets/img/artikel/'.$newimg, 90);
						if($imglama!=null||$imglama!=""){
							$filePath = ROOTPATH . 'public/assets/img/artikel/'. $imglama;
							if(is_writable($filePath)){
								$deleted = unlink($filePath);
							}
						}
					$imglama = $newimg;
				}

				$status = 'draft'; $publishat = null;

				$slug = slugify($this->request->getPost('judul'));
				$insertData = [
					'kategori' => (int)$this->request->getPost('kategori'),
					'judul' => $this->request->getPost('judul'),
					'konten' => $this->request->getPost('konten'),
					'gambar' => $imglama,
					'status' => $status,
					'publish_at' => $publishat,
					'update_at' => date("Y-m-d H:i:s"),
					'penulis' => (int)$this->session->get('user_id'),
					'slug'  => $slug,
				];
				$insertid = $this->artikel->ubah($insertData,$id);
				if($insertid){
					$this->tagartikel->reset($id);
					foreach ($tags as $tag) {
						($this->tags->cekTags($tag) ?: $this->addTags($tag)); // JIKA TAG BELUM ADA MAKA MASUKIN KE TABLE TAGS
						$tagData = [
							'tag' => $tag,
							'berita' => $id,
						];
						$insert = $this->tagartikel->simpan($tagData);
						if(!$insert){
							return redirect()->back()->withInput()->with('msg', [0,lang('Msg.gagal_mengubah_artikel')]);
						}
					}
					$this->log("update",$id,"artikel",json_encode($artikel),json_encode($insertData));
					if($this->ionAuth->inGroup([1,3])){
						return redirect()->to(site_url('/home/artikel'))->with('msg', [1,lang('Msg.berhasil_mengubah_artikel')]);
					}
					return redirect()->to(site_url('/home/artikel'))->with('msg', [1,lang('Msg.berhasil_mengubah_artikel')]);
					
				}else{
					return redirect()->back()->withInput()->with('msg', [0,lang('Msg.gagal_mengubah_artikel')]);
				}
			}else{
				$data = [
					'title' => "Ubah Artikel",
					'breadcump' => ['Home','Artikel','Ubah Artikel'],
					'nav' => 3,
					'id' => $id,
					'imglama' => $artikel[0]['gambar'],
					'content' => $artikel[0]['konten'],
				];
				
				$data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : "";

				$data['judul'] = [
					'name'  => 'judul',
					'id'    => 'judul',
					'type'  => 'text',
					'class' => 'form-control',
					'required' => true,
					'autofocus' => true,
					'placeholder' => 'Judul Artikel',
					'value' => set_value('judul', $artikel[0]['judul'] ?: ''),
                ];
                
				$kategori = null; $kategories = $this->kategori->getKategori();
				foreach($kategories as $item) $kategori[$item['id']] = $item['kategori'];
				
				$data['kategori'] = ['kategori',$kategori,$artikel[0]['kategori'],'class="form-control" required="true"'];

				$tag = null; $tags = $this->tags->getTags();
				$tagart = []; $tagsart = $this->tagartikel->getByArtikel($id);
				foreach($tags as $item) $tag[$item['tags']] = $item['tags'];
				foreach($tagsart as $item) array_push($tagart,$item['tag']);

				$data['tags'] = ['tags[]',$tag,$tagart,'class="form-control select2" multiple="multiple" data-placeholder="Select a Tags"
				style="width: 100%;" required="true"','tags'];

                $data['gambar'] = [
					'name'  => 'gambar',
					'id'    => 'gambar',
					'placeholder' => 'Gambar Sampul',
					'keterangan' => 'max size 2 mb, 450 x 700 px',
					'value' => set_value('gambar'),
                ];
				$data['notif'] = $this->notifikasi->getNotifikasi();
				return view('home/artikel/ubah',$data);
			}
		}
	}

	public function act(int $status,int $id){
		if (!$this->ionAuth->loggedIn()){
			return redirect()->to(site_url('/auth/login'))->with('msg', [0,lang("Msg.belumlogin")]);
		}else if (! $this->ionAuth->inGroup([1,3])){
            return redirect()->back()->with('msg', [0,lang("Msg.bukanadmineditor")]);
        }else{
			if(!empty($id)){
				$message = null;
				if($status == 1){
					if($this->artikel->activate($id)){
						$this->log("publish artikel",$id,"artikel");
						$message = [1, lang('Msg.berhasil_publish_artikel')];
					}else{
						$message = [0, lang('Msg.gagal_publish_artikel')];
					}
				}elseif($status == 0){
					if($this->artikel->deactivate($id)){
						$this->log("unpublish artikel",$id,"artikel");
						$message = [1, lang('Msg.berhasil_unpublish_artikel')];
					}else{
						$message = [0, lang('Msg.gagal_unpublish_artikel')];
					}
				}else{
					return redirect()->back()->with("msg", [0,"Unknown command"]);
				}
				return redirect()->to('/home/artikel')->with('msg', $message);
			}else{
				return redirect()->back()->with("msg", [0,"Missing parameters, try again later"]);
			}
		}
	}

	public function hapus(int $id){
		if (!$this->ionAuth->loggedIn()){
			return redirect()->to('/auth/login')->with('msg', [0,"Please login first"]);
		}else if (! $this->ionAuth->isAdmin()){
			return redirect()->back()->with('msg', [0,"You must be an administrator to view this page."]);
		}else{
			if(!empty($id)){
				$data = [
					'delete_at' => date("Y-m-d H:i:s"),
				];
				$status = $this->artikel->ubah($data,$id);
				if($status){
					$this->log("delete",$id,"tags");
					$message = [1, lang('Msg.berhasil_menghapus_artikel')];
				}else{
					$message = [0, lang('Msg.gagal_menghapus_artikel')];
				}
				return redirect()->to(site_url('/home/artikel'))->with('msg', $message);
			}else{
				return redirect()->back()->with("msg", [0,"Missing parameters, try again later"]);
			}
		}
	}

	private function addTags($tag){
		$slug = slugify($tag);
		$insertData = [
			'tags' => $tag,
			'slug'  => $slug,
		];
		$insertid = $this->tags->simpan($insertData);
		if($insertid){
			$this->log("insert",$insertid,"tags");
			return $insertid;
		}
		return false;
	}

	//--------------------------------------------------------------------

}
