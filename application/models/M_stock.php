<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_stock extends CI_Model{

public function view_all_stock($kode_toko)
 {
 	$sql = "SELECT tbl_stok.ID_BARANG AS ID_BARANG,
   	    tbl_item.NAMA_ITEM AS NAMA,
 		tbl_stok.JUMLAH AS JUMLAH,
        tbl_toko.NAMA_TOKO AS NAMA_TOKO
 		FROM tbl_stok, tbl_item, tbl_toko
        WHERE tbl_stok.ID_BARANG = tbl_item.ID_ITEM AND tbl_stok.ID_STORE = tbl_toko.ID_TOKO AND tbl_stok.ID_STORE= $kode_toko" ;

    $result = $this->db->query($sql);
    return $result->result();
 }
 public function view_all_stock2($kode_toko)
 {
 	$sql = "SELECT * FROM tbl_toko WHERE ID_TOKO = $kode_toko" ;

    $result = $this->db->query($sql);
    return $result->result();
 }

 function ambil_jumlah($ID_BARANG,$ID_STORE){
		$this->db->select('JUMLAH');
 		$this->db->from('tbl_stok');
 		$this->db->where('ID_BARANG', $ID_BARANG);
 		$this->db->where('ID_STORE', $ID_STORE);
 		 $this->db->limit(1);

        return $this->db->get();
	}

	function ambil_id(){
		$this->db->select('NAMA_PENGIRIMAN');
 		$this->db->from('tbl_pengiriman');
 		$this->db->order_by('ID_PENGIRIMAN', 'desc');
 		$rs_data = $this->db->get();
 		return $rs_data;
	}

    function update_stok($jumlahstok,$brg,$tok){   
        $this->db->set('JUMLAH', $jumlahstok); //value that used to update column  
        $this->db->where('ID_BARANG', $brg);
        $this->db->where('ID_STORE', $tok); //which row want to upgrade  
        $this->db->update('tbl_stok');  //table name
    }


    // dashboard admin
    public function retur_perbulan($now)
    {
        
        $this->db->select('*');
        $this->db->from('tbl_reture');
        $this->db->like('tgl_reture', $now);
        $rs_data = $this->db->get();
        return $rs_data;

    }

    public function pengiriman_perbulan($now)
    {
        
        $this->db->select('*');
        $this->db->from('tbl_pengiriman');
        $this->db->like('tgl_pengiriman', $now);
        $rs_data = $this->db->get();
        return $rs_data;

    }

    public function total_barang_now()
    {
        
        $this->db->select('sum(jumlah) as jumlah');
        $this->db->from('tbl_stok');
        $rs_data = $this->db->get();
        return $rs_data;

    }

    // dashboard BP
    public function retur_perbulan_bp($now,$usr)
    {
        
        $this->db->select('*');
        $this->db->from('tbl_reture');
        $this->db->like('tgl_reture', $now);
        $this->db->where('BP_RETURE', $usr);
        $rs_data = $this->db->get();
        return $rs_data;

    }

    public function pengiriman_perbulan_bp($now,$nip)
    {
        
        $this->db->select('*');
        $this->db->from('tbl_pengiriman');
        $this->db->like('tgl_pengiriman', $now);
        $this->db->where('BP_PENGIRIMAN', $nip);
        $rs_data = $this->db->get();
        return $rs_data;

    }

    public function total_barang_now_bp($user)
    {
        
        $this->db->select('sum(jumlah) as jumlah');
        $this->db->from('tbl_stok');
        $this->db->where('ID_STORE', $user);
        $rs_data = $this->db->get();
        return $rs_data;

    }

    public function select_toko($nip)
    {
        
        $this->db->select('ID_TOKO_JAGA');
        $this->db->from('tbl_penjaga');
        $this->db->where('NIP_JAGA', $nip);
        $rs_data = $this->db->get();
        return $rs_data;

    }

}
