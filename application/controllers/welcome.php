<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('M_stock','M_excel','M_item'));
		// // $this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		// include_once("genetika.php");
		// // define('IS_TEST','FALSE');
		
	}

	public function index()
	{
		// $cek = $this->M_excel->select_status();
		$tgl = "2019-04";
		$cek = "1";

		$nip = "1020";
		$toko = 25;
		
		// $nip = $this->session->userdata('nip');
		$user_toko = $this->M_stock->select_toko($nip)->row()->ID_TOKO_JAGA;
		$nama_bp = $this->M_stock->select_pegawai($nip)->row()->NAMA_PEG;
		$nama_toko = $this->M_stock->select_nama_toko($user_toko)->row()->NAMA_TOKO;
		$select_tgl_ai = $this->M_excel->select_tanggal($tgl, $user_toko)->row();
		$coba = array();
		$i = 0;
       

		
        echo "<pre>";
		var_dump($select_tgl_ai);	
	}
}