<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_category extends CI_Model{

public function view_category()
 {
 	$sql = "SELECT tbl_kategori.ID_KATEGORI AS ID_KATEGORI, 
 		tbl_kategori.NAMA_KATEGORI AS NAMA_KATEGORI, 
 		tbl_kategori.BATAS_KIRIM AS BATAS_KIRIM,
 		tbl_kategori.AKTIF AS AKTIF
 		
 		FROM tbl_kategori
        WHERE tbl_kategori.ID_KATEGORI and tbl_kategori.AKTIF='y'";

    $result = $this->db->query($sql);
    return $result->result();

 }



public function hapus_category($id){
	$sql= "UPDATE tbl_kategori SET AKTIF ='n' WHERE ID_KATEGORI = '$id'";

	$result = $this->db->query($sql);
	// var_dump($sql);
	// return $result->();
		// $this->db->where($id);
		// $this->db->update('tbl_item',$data);
}

}
