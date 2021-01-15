<?php namespace App\Models;
use CodeIgniter\Model;
 
class ArtikelModel extends Model
{
    protected $table = 'artikel';

    public function activate($id){
        $data = [
            'status' => 'publish',
            'publish_at' => date("Y-m-d H:i:s"),
        ];
        return $this->ubah($data,$id);
    }

    public function deactivate($id){
        $data = [
            'status' => 'draft',
            'publish_at' => null,
        ];
        return $this->ubah($data,$id);
    }

    

    public function getArtikelByUser($id){
        $tbl = 'users';
        $tbl1 = 'kategori';
        if($id !== false){
            return $this->select($this->table.".*, $tbl.first_name as namapenulis, $tbl1.kategori as namakategori")
                    ->table($this->table)
                    ->join($tbl, $this->table.".penulis = $tbl.id")
                    ->join($tbl1, $this->table.".kategori = $tbl1.id")
                    ->where($this->table.".penulis",$id)
                    ->where($this->table.".delete_at",null)
                    ->orderby($this->table.".publish_at DESC")
                    ->get()
                    ->getResultArray();
        }
        return false;
    }

    public function getArtikel($id = false){
        $tbl = 'users';
        $tbl1 = 'kategori';
        if($id === false){
            return $this->select($this->table.".*, $tbl.first_name as namapenulis, $tbl1.kategori as namakategori")
                    ->table($this->table)
                    ->join($tbl, $this->table.".penulis = $tbl.id")
                    ->join($tbl1, $this->table.".kategori = $tbl1.id")
                    ->where($this->table.".delete_at",null)
                    ->orderby($this->table.".publish_at DESC")
                    ->get()
                    ->getResultArray();
        } else {
            return $this->select($this->table.".*, $tbl.first_name as namapenulis, $tbl1.kategori as namakategori")
                    ->table($this->table)
                    ->join($tbl, $this->table.'.penulis = '.$tbl.'.id')
                    ->join($tbl1, $this->table.'.kategori = '.$tbl1.'.id')
                    ->where($this->table.".id",$id)
                    ->where($this->table.".delete_at",null)
                    ->orderby($this->table.".publish_at DESC")
                    ->get()
                    ->getResultArray();
        }  
    }

    public function simpan($data){
        $query = $this->db->table($this->table)->insert($data);
        $id = $this->db->insertId($this->table);
        return $id ?? false;
    }

    public function ubah($data, $id){
        $query = $this->db->table($this->table)->update($data, array('id' => $id));
        return $query;
    }

    public function hapus($id){
        $query = $this->db->table($this->table)->delete(array('id' => $id));
        return $query;
    } 
 
}