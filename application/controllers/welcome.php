<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('M_stock');
		// // $this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		// include_once("genetika.php");
		// // define('IS_TEST','FALSE');
		
	}

	public function index()
	{
		// $cek = $this->M_excel->select_status();
		$tgl = "2019-03";
		$cek = "1";
		$cek =$this->M_stock->coba_barang($tgl);
		 $cek_stat = $cek;
		echo "<pre>";
		var_dump($cek_stat);

		// foreach ($cek_stat as $d) {
		//  		$cek	= $d->status;
		//  		echo "<pre>";
		//  		var_dump($cek);

		//  		if ($cek == 1) {
		//  			echo "jembot"; }
		//  		elseif ($cek == 2) {
		//  			# code...
		//  			echo "kontol"; }
		//  		// }elseif ($cek_stat == 3) {
		//  		// 	# code...
		//  		// 	echo "$cek_stat";
		//  		// }

		//  }

	}
}