<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_excel extends CI_Model{

	// Listing
	// public function report_monthly() {
	// 	$this->db->select('*');
	// 	$this->db->from('tbl_stok');
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	// public function machine() {
	// 	$this->db->select('*');
	// 	$this->db->from('tbl_item');
	// 	$this->db->where('AI_PRODUK', 1);
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }
	// public function capsule() {
	// 	$this->db->select('*');
	// 	$this->db->from('tbl_item');
	// 	$this->db->where('AI_PRODUK', 2);
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }
	// public function wire() {
	// 	$this->db->select('*');
	// 	$this->db->from('tbl_item');
	// 	$this->db->where('AI_PRODUK', 3);
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }
	// public function hampers() {
	// 	$this->db->select('*');
	// 	$this->db->from('tbl_item');
	// 	$this->db->where('AI_PRODUK', 4);
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	public function export($tgl)
	{
		$this->db->select('a.stok_awal, a.jumlah, a.stok_akhir, a.created_at, b.nama_item');
 		$this->db->from('tbl_mutasi as a');
 		$this->db->join('tbl_item as b', 'a.id_barang = b.id_item');
 		$this->db->like('a.created_at', $tgl);
 		return $this->db->get();
	}

	public function export_satu($tgl,$ID_TOKO)
	{
		$this->db->select('a.stok_awal, a.jumlah, a.stok_akhir, a.created_at, b.nama_item, a.status');
 		$this->db->from('tbl_mutasi as a');
 		$this->db->join('tbl_item as b', 'a.id_barang = b.id_item');
 		$this->db->like('a.created_at', $tgl);
 		$this->db->where('id_toko', $ID_TOKO);
 		return $this->db->get();
	}

	public function select_status()
	{
		$this->db->select('status');
 		$this->db->from('tbl_mutasi');
 		$rs_data = $this->db->get();
 		return $rs_data;
	}
	
	public function ambil_toko()
	{
		$this->db->select('ID_TOKO, NAMA_TOKO');
 		$this->db->from('tbl_toko');
 		return $this->db->get();
	}

	public function ambil_nama_toko($toko)
	{
		$this->db->select('NAMA_TOKO');
 		$this->db->from('tbl_toko');
 		$this->db->where('ID_TOKO', $toko);
 		return $this->db->get();
	}

	public function ambil_nama()
	{
		$this->db->select('*');
 		$this->db->from('tbl_item');
 		return $this->db->get();
	}

	public function ambil_id($nama)
	{
		$this->db->select('ID_ITEM');
 		$this->db->from('tbl_item');
 		$this->db->where('NAMA_ITEM', $nama);
 		return $this->db->get();
	}

	public function cek_stok($id_brg,$toko,$tgl)
	{
		$this->db->select('stok_awal');
 		$this->db->from('tbl_mutasi');
 		$this->db->where('id_barang', $id_brg);
 		$this->db->where('id_toko', $toko);
 		$this->db->like('created_at', $tgl);
 		$this->db->order_by('id_mutasi', 'asc');
 		return $this->db->get();
	}

	public function ambil_stok($id_brg,$toko,$tgl)
	{
		$this->db->select('stok_awal');
 		$this->db->from('tbl_mutasi');
 		$this->db->where('id_barang', $id_brg);
 		$this->db->where('id_toko', $toko);
 		$this->db->like('created_at', $tgl);
 		$this->db->order_by('id_mutasi', 'asc');
 		$this->db->limit(1);
 		return $this->db->get();
	}


	public function ambil_jumlah_masuk($id_brg,$toko,$tgl)
	{
		$this->db->select_sum('jumlah');
 		$this->db->from('tbl_mutasi');
 		$this->db->where('id_barang', $id_brg);
 		$this->db->where('id_toko', $toko);
 		$this->db->like('created_at', $tgl);
 		$this->db->where('status', 1);
 		return $this->db->get();
	}


	public function ambil_jumlah_sell($id_brg,$toko,$tgl)
	{
		$this->db->select_sum('jumlah');
 		$this->db->from('tbl_mutasi');
 		$this->db->where('id_barang', $id_brg);
 		$this->db->where('id_toko', $toko);
 		$this->db->like('created_at', $tgl);
 		$this->db->where('status', 2);
 		return $this->db->get();
	}

	public function ambil_jumlah_retur($id_brg,$toko,$tgl)
	{
		$this->db->select_sum('jumlah');
 		$this->db->from('tbl_mutasi');
 		$this->db->where('id_barang', $id_brg);
 		$this->db->where('id_toko', $toko);
 		$this->db->like('created_at', $tgl);
 		$this->db->where('status', 3);
 		return $this->db->get();
	}

	public function cek_stok_akhir($id_brg,$toko,$tgl)
	{
		$this->db->select('stok_akhir');
 		$this->db->from('tbl_mutasi');
 		$this->db->where('id_barang', $id_brg);
 		$this->db->where('id_toko', $toko);
 		$this->db->like('created_at', $tgl);
 		$this->db->order_by('id_mutasi', 'desc');
 		return $this->db->get();
	}

	public function ambil_stok_akhir($id_brg,$toko,$tgl)
	{
		$this->db->select('stok_akhir');
 		$this->db->from('tbl_mutasi');
 		$this->db->where('id_barang', $id_brg);
 		$this->db->where('id_toko', $toko);
 		$this->db->like('created_at', $tgl);
 		$this->db->order_by('id_mutasi', 'desc');
 		$this->db->limit(1);
 		return $this->db->get();
	}
}