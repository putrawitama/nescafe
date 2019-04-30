<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bp extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model(array('View_of','M_item_request','M_item_delivery','M_stock','M_item_reture','M_sellout','M_excel', 'M_item'));

		if ($this->session->userdata('nip') == NULL){
            redirect('Controller_login');
        }
	}

	public function index()
	{	
		$nip = $this->session->userdata('nip');
		$user = $this->M_stock->select_toko($nip)->row()->ID_TOKO_JAGA;
		date_default_timezone_set('Asia/Karachi'); # add your city to set local time zone
		$now = date('Y-m');
		$reture = $this->M_stock->retur_perbulan_bp($now, $nip)->result();
		$kirim = $this->M_stock->pengiriman_perbulan_bp($now, $nip)->result();
		$barang = $this->M_stock->total_barang_now_bp($user)->row()->jumlah;

		$data['jumlah_reture'] = count($reture);
		$data['jumlah_kirim'] = count($kirim);
		$data['total_barang'] = $barang;
		
		$data['now'] = $now;
		$data['content'] = 'bp/dasboard';
		$this->load->view('template', $data);
	}


	public function view_item_request()
	{
		$usr = $this->session->userdata('nip');
		$test = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($test->result_array() as $data) {
			$data['toko'] = $data['ID_TOKO_JAGA'];
		}
		$data['jaga'] = $this->db->query("SELECT * 
										FROM tbl_penjaga , tbl_pegawai , tbl_toko 
     									 WHERE tbl_penjaga.NIP_JAGA=tbl_pegawai.NIP
									        AND tbl_penjaga.ID_TOKO_JAGA =tbl_toko.ID_TOKO
											AND NIP_JAGA = '$usr' 
											LIMIT 1");

		$data['lastcode'] = $this->db->query("SELECT * FROM tbl_permintaan ORDER BY KODE_PERMINTAAN DESC LIMIT 1");
		$data['kat'] = $this->db->query("SELECT * FROM tbl_toko");
		$data['bpkat'] = $this->db->query("SELECT * FROM tbl_pegawai WHERE LEVEL = 2 ");
		$data['cetak1'] = $this->M_item_request->view_item_request1($data['toko']);
		$data['content'] = 'Bp/view_item_request';
		$this->load->view('template', $data);
	}
	public function add_code_request()
	{
			$data = array (
				'KODE_PERMINTAAN'		=> $this->input->post('code'),
				'TGL_PERMINTAAN'		=> $this->input->post('tgl'),
				'TOKO_PERMINTAAN'		=> $this->input->post('toko'),
				'BP_PERMINTAAN'			=> $this->input->post('bp'),
				'STATUS_PERMINTAAN'		=> "1"
			);

			$this->db->insert('tbl_permintaan', $data);
			redirect('Bp/add_item_request/'.$this->input->post('code'));
	}

	public function add_item_request($kode_kirim)
	{
		$data['tanda'] = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tanggal = date("Y-m-d");
			$checkitem = $this->input->post('item');
			$data = array (
				'KODE_PERMINTAAN'		=> $kode_kirim,
				'NAMA_PERMINTAAN'		=> $this->input->post('item'),
				'JUMLAH_PERMINTAAN'		=> $this->input->post('jumlah'),
				'TGL_PERMINTAAN'		=> $tanggal,
				'TOKO_PERMINTAAN'		=> $this->input->post('toko'),
				'BP_PERMINTAAN'			=> $this->input->post('bp'),
				'STATUS_PERMINTAAN'		=> "1"
			);

			$check = $this->db->query("SELECT * FROM tbl_permintaan WHERE KODE_PERMINTAAN = '$kode_kirim' AND NAMA_PERMINTAAN = '$checkitem'");
			if ($check->num_rows() == 0) {
				$this->db->insert('tbl_permintaan', $data);
			}else {
				$x = $this->input->post('id');
				$y = $this->input->post('jumlah');
				$this->db->query("UPDATE tbl_permintaan SET JUMLAH_PERMINTAAN = JUMLAH_PERMINTAAN + $y WHERE ID_PERMINTAAN = '$x'");
			}
			redirect('Bp/add_item_request/'.$kode_kirim);
		}
		$data['code'] = $kode_kirim;
		$set = $this->db->query("SELECT * FROM tbl_permintaan WHERE KODE_PERMINTAAN = '$kode_kirim'");
		foreach ($set->result() as $print) {
			$data['bp'] = $print->BP_PERMINTAAN;
			$data['toko'] = $print->TOKO_PERMINTAAN;
		}
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_item");
		$data['cetak1'] = $this->M_item_request->view_item_request2($kode_kirim);
		$data['content'] = 'Bp/add_item_request';

		$this->load->view('template', $data);
	}

	function cancel_item_request($id)
	 {
			$kode_kirim = $this->uri->segment(3);

			$this->M_item_request->cancel_item_request($kode_kirim) ;
				 {
						redirect('Bp/view_item_request');
				 }
	 }

	public function update_item_request($kode_minta)
	{

		$data['tanda'] = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			echo "string";
			$tanggal = date("Y-m-d");
			$checkitem = $this->input->post('item');
			$data = array (
				'KODE_PERMINTAAN'		=> $kode_minta,
				'NAMA_PERMINTAAN'		=> $this->input->post('item'),
				'JUMLAH_PERMINTAAN'	=> $this->input->post('jumlah'),
				'TGL_PERMINTAAN'		=> $tanggal,
				'TOKO_PERMINTAAN'		=> $this->input->post('toko'),
				'BP_PERMINTAAN'			=> $this->input->post('bp'),
				'STATUS_PERMINTAAN'		=> "1"
			);

			$check = $this->db->query("SELECT * FROM tbl_permintaan WHERE KODE_PERMINTAAN = '$kode_minta' AND NAMA_PERMINTAAN= '$checkitem'");
			if ($check->num_rows() == 0) {
				$this->db->insert('tbl_permintaan', $data);
			}else {
				$x = $this->input->post('id');
				$y = $this->input->post('jumlah');
				$this->db->query("UPDATE tbl_permintaan SET JUMLAH_PERMINTAAN = JUMLAH_PERMINTAAN + $y WHERE ID_PERMINTAAN = '$x'");
			}
			redirect('Bp/update_item_request/'.$kode_minta);

		}

		$data['code'] = $kode_minta;
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_item");
		$data['cetak1'] = $this->M_item_request->view_item_request2($kode_minta);
		$data['content'] = 'Bp/update_item_request';

		$this->load->view('template', $data);
	}

	public function update_item_request2($kode_kirim,$kode_item)
	{
		$data['tanda'] = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tanggal = date("Y-m-d");
			$data = array (
				'KODE_PERMINTAAN'			=> $kode_kirim,
				'NAMA_PERMINTAAN'		=> $this->input->post('item'),
				'JUMLAH_PERMINTAAN'		=> $this->input->post('jumlah'),
				'TGL_PERMINTAAN'		=> $tanggal,
				'TOKO_PERMINTAAN'		=> $this->input->post('toko'),
				'BP_PERMINTAAN'			=> $this->input->post('bp'),
				'STATUS_PERMINTAAN'		=> $this->input->post('status')
			);


			$this->db->insert('tbl_permintaan', $data);
			redirect('Bp/update_item_request/'.$kode_kirim);
		}
		$data['code'] = $kode_kirim;
		$set = $this->db->query("SELECT * FROM tbl_permintaan WHERE KODE_PERMINTAAN = '$kode_kirim'");
		$data['tanda'] = $kode_item;
		echo $kode_item;
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_item");
		$data['cetak1'] = $this->M_item_request->view_item_request2($kode_kirim);
		$data['content'] = 'Bp/update_item_request';

		$this->load->view('template', $data);
	}

	public function edit_item_request2()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$a = $this->input->post('id_item');
			$b = $this->input->post('kode_item');

			$data = array (
				'JUMLAH_PERMINTAAN'	=> $this->input->post('jumlah'),
			);

			$this->db->update('tbl_permintaan', $data, "ID_PERMINTAAN = '$a'");
			var_dump($a);

		redirect('Bp/update_item_request/'.$b);
		}
	}

	public function hapus_item_request2($id,$kode_id)
	{
		$this->db->delete('tbl_permintaan', array('ID_PERMINTAAN' => $id));
		redirect('Bp/update_item_request/'.$kode_id);
	}

	public function detail_item_request($KODE_PERMINTAAN) {
		$data['deliv'] = $this->M_item_request->find($KODE_PERMINTAAN);
		$data['cetak1'] = $this->M_item_request->view_item_request2($KODE_PERMINTAAN);
		$data['content'] = 'Bp/detail_item_request';
		$this->load->view('template', $data);
	}



	public function view_item_delivery()
	{
		$data['cetak1'] = $this->M_item_delivery->view_item_delivery();
		$data['content'] = 'bp/view_item_delivery';
		$this->load->view('template', $data);
	}

	public function accepting_item_delivery()
	{
		$usr = $this->session->userdata('nip');
		$test = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($test->result_array() as $data) {
			$data['toko'] = $data['ID_TOKO_JAGA'];
		}
		$data['cetak1'] = $this->M_item_delivery->view_accepting_delivery($data['toko']);
		$data['content'] = 'bp/view_accepting_delivery';
		$this->load->view('template', $data);
	}

	public function accepting_item_delivery2($kode_delivery)
	{
		$usr = $this->session->userdata('nip');
		$test = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		
		foreach ($test->result_array() as $data) {
			$data1 = $data['ID_TOKO_JAGA'];

		}
	
			$kode = $kode_delivery;
			$set = $this->db->query("SELECT * FROM tbl_pengiriman WHERE KODE_PENGIRIMAN = '$kode_delivery' AND NAMA_PENGIRIMAN IS NOT NULL ");
		
					foreach ($set->result_array() as $cetak1) {
					
							$ID_BARANG	= $cetak1['NAMA_PENGIRIMAN'];
							$ID_STORE   = $cetak1['TOKO_PENGIRIMAN'];
							// echo 'id barang'.$ID_BARANG;

							 $test = $this->db->query("SELECT * FROM tbl_stok WHERE ID_BARANG = '$ID_BARANG' AND ID_STORE = '$ID_STORE'");


							 if ($test ->num_rows() > 0) {
						
										$data = array (
											'ID_BARANG'		=> $cetak1['NAMA_PENGIRIMAN'],
											'JUMLAH'		=> $cetak1['JUMLAH_PENGIRIMAN'],
											'ID_STORE'		=> $cetak1['TOKO_PENGIRIMAN'],
										);
									
										$y = $data['JUMLAH'];
										$x = $data['ID_BARANG'];
										$z = $data['ID_STORE'];


										if ($x <> NULL AND $x <> '') {
											$sql= "UPDATE tbl_stok SET JUMLAH = JUMLAH + $y WHERE ID_BARANG = '$x' AND ID_STORE = '$z'";
											// echo $sql;
											$result = $this->db->query($sql);

											
					date_default_timezone_set('Asia/Karachi'); # add your city to set local time zone
					$now = date('Y-m-d');

					$get_id = $this->M_stock->ambil_id()->result();
					$jumlah_stok = $this->M_stock->ambil_jumlah($ID_BARANG, $ID_STORE)->row()->JUMLAH;
					$STOK_AWAL = $jumlah_stok - $cetak1['JUMLAH_PENGIRIMAN'];

					$data_mutasi = array (
						'ID_TOKO'			=> $cetak1['TOKO_PENGIRIMAN'],
						'ID_BARANG'			=> $cetak1['NAMA_PENGIRIMAN'],
						'STOK_AWAL'		  	=> $STOK_AWAL,
						'JUMLAH'		  	=> $cetak1['JUMLAH_PENGIRIMAN'],
						'STOK_AKHIR'		=> $jumlah_stok,
						'CREATED_AT'		=> $now,
						'STATUS'			=> 1
					);

					$this->db->insert('tbl_mutasi', $data_mutasi);
										}

							  		
							  }else{
									
										$data = array (
											'JUMLAH'		=> $cetak1['JUMLAH_PENGIRIMAN'],
											'ID_BARANG'		=> $cetak1['NAMA_PENGIRIMAN'],
											'ID_STORE'		=> $cetak1['TOKO_PENGIRIMAN'],
										);
										$x = $data['ID_BARANG'];
										
										if ($x <> NULL AND $x <> '') {
											$this->db->insert('tbl_stok', $data);
										}							
							  }
							 
				}
				
							$sql = "UPDATE tbl_pengiriman
									SET STATUS_PENGIRIMAN=2
									WHERE KODE_PENGIRIMAN ='".$kode."'
									";

							$result = $this->db->query($sql);

			
			
			redirect("Bp/accepting_item_delivery");

	}

	public function detail_item_delivery($KODE_PENGIRIMAN) {
		$data['deliv'] = $this->M_item_delivery->find($KODE_PENGIRIMAN);
		$data['cetak1'] = $this->M_item_delivery->view_item_delivery2($KODE_PENGIRIMAN);
		$data['content'] = 'Bp/detail_item_delivery';
		$this->load->view('template', $data);
	}

public function view_stock()
	{
		$usr = $this->session->userdata('nip');
		$test = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($test->result_array() as $data) {
			$data['toko'] = $data['ID_TOKO_JAGA'];
		}

		$data['cetak2'] = $this->M_stock->view_all_stock($data['toko']);
		$data['content'] = 'Bp/view_stock';
		$this->load->view('template', $data);
	}

	public function view_item_reture()
	{
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query(
			"SELECT * FROM tbl_penjaga
			WHERE NIP_JAGA = '$usr'
			LIMIT 1");
		$data['lastcode'] = $this->db->query("SELECT * FROM tbl_reture ORDER BY KODE_RETURE DESC LIMIT 1");

		$data['cetak1'] = $this->M_item_reture->view_item_reture();
		$data['content'] = 'Bp/view_item_reture';
		$this->load->view('template', $data);
	}

	public function add_code_reture()
	{
			$data = array (
				'KODE_RETURE'		=> $this->input->post('code'),
				'TGL_RETURE'		=> $this->input->post('tgl'),
				'TOKO_RETURE'		=> $this->input->post('toko'),
				'BP_RETURE'			=> $this->input->post('bp'),
				'STATUS_RETURE'		=> "1"
			);

			$this->db->insert('tbl_reture', $data);
			redirect('Bp/add_item_reture/'.$this->input->post('code'));
	}

	public function add_item_reture($kode_reture)
	{
		$data['tanda'] = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tanggal = date("Y-m-d");
			$checkitem = $this->input->post('item');
			$data = array (
				'KODE_RETURE'		=> $kode_reture,
				'NAMA_RETURE'		=> $this->input->post('item'),
				'JUMLAH_RETURE' 	=> $this->input->post('jumlah'),
				'TGL_RETURE'		=> $tanggal,
				'TOKO_RETURE'		=> $this->input->post('toko'),
				'BP_RETURE'			=> $this->input->post('bp'),
				'STATUS_RETURE'		=> "1"
			);

			$brg = $this->input->post('item');
			$tok = $this->input->post('toko');
			$checkjumlah = $this->input->post('jumlah');
			$check = $this->db->query("SELECT * FROM tbl_reture WHERE KODE_RETURE = '$kode_reture' AND NAMA_RETURE = '$checkitem'");
			if ($check->num_rows() == 0) {

				$stock = $this->db->query("SELECT * FROM tbl_stok WHERE ID_BARANG = '$brg' AND ID_STORE = '$tok' LIMIT 1");
				
				foreach ($stock->result() as $key1) {
					$jstok = $key1->JUMLAH;
				}

					if ($checkjumlah > $jstok) {
						echo "string";
					}else{
						$this->db->insert('tbl_reture', $data);
					}

			}else {
				$x = $this->input->post('id');
				$y = $this->input->post('jumlah');
				$this->db->query("UPDATE tbl_reture SET JUMLAH_RETURE = JUMLAH_RETURE + $y WHERE ID_RETURE = '$x'");
			}
			redirect('Bp/add_item_reture/'.$kode_reture);
		}
		$data['code'] = $kode_reture;
		$set = $this->db->query("SELECT * FROM tbl_reture WHERE KODE_RETURE = '$kode_reture'");
		foreach ($set->result() as $print) {
			$data['bp'] = $print->BP_RETURE;
			$data['toko'] = $print->TOKO_RETURE;
		}

		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($jaga->result() as $key) {
			$tok = $key->ID_TOKO_JAGA;
		}
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_stok WHERE ID_STORE = '$tok' ");

		$data['cetak1'] = $this->M_item_reture->view_item_reture2($kode_reture);
		$data['content'] = 'Bp/add_item_reture';

		$this->load->view('template', $data);
	}

	function cancel_item_reture($id)
	{
		$kode_kirim = $this->uri->segment(3);
		$this->M_item_reture->cancel_item_reture($kode_kirim) ;
		redirect('Bp/view_item_reture');
	}

	public function update_item_reture($kode_minta)
	{
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($jaga->result() as $key) {
			$tok = $key->ID_TOKO_JAGA;
		}

		$data['tanda'] = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$brg = $this->input->post('item');
			$checkjumlah = $this->input->post('jumlah');
			$stock = $this->db->query("SELECT * FROM tbl_stok WHERE ID_BARANG = '$brg' AND ID_STORE = '$tok' LIMIT 1");
			foreach ($stock->result() as $key1) {
				$jstok = $key1->JUMLAH;
			}
			if ($checkjumlah > $jstok) {
				echo "stok kurang";
			}else {
				$tanggal = date("Y-m-d");
				$checkitem = $this->input->post('item');
				$data = array (
					'KODE_RETURE'		=> $kode_minta,
					'NAMA_RETURE'		=> $this->input->post('item'),
					'JUMLAH_RETURE'		=> $this->input->post('jumlah'),
					'TGL_RETURE'		=> $tanggal,
					'TOKO_RETURE'		=> $this->input->post('toko'),
					'BP_RETURE'			=> $this->input->post('bp'),
					'STATUS_RETURE'		=> "1"
				);

				$check = $this->db->query("SELECT * FROM tbl_reture WHERE KODE_RETURE = '$kode_minta' AND NAMA_RETURE= '$checkitem'");
				if ($check->num_rows() == 0) {
					$this->db->insert('tbl_reture', $data);
				}else {
					$x = $this->input->post('id');
					$y = $this->input->post('jumlah');
					$this->db->query("UPDATE tbl_reture SET JUMLAH_RETURE = JUMLAH_RETURE + $y WHERE ID_RETURE = '$x'");
				}
				redirect('Bp/update_item_reture/'.$kode_minta);
			}


		}
		$data['tanda'] = 0;
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($jaga->result() as $key) {
			$tok = $key->ID_TOKO_JAGA;
		}

		$data['code'] = $kode_minta;

		$data['itkat'] = $this->db->query("SELECT * FROM tbl_stok WHERE ID_STORE = '$tok' ");
		$data['cetak1'] = $this->M_item_reture->view_item_reture2($kode_minta);
		$data['content'] = 'Bp/update_item_reture';

		$this->load->view('template', $data);
	}

	public function update_item_reture2($kode_kirim,$kode_item)
	{
		$usr = $this->session->userdata('nip');
		$data['tanda'] = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$brg = $this->input->post('item');
			$checkjumlah = $this->input->post('jumlah');
			$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
			foreach ($jaga->result() as $key) {
				$tok = $key->ID_TOKO_JAGA;
			}
			$stock = $this->db->query("SELECT * FROM tbl_stok WHERE ID_BARANG = '$brg' AND ID_STORE = '$tok' LIMIT 1");
			foreach ($stock->result() as $key1) {
				$jstok = $key1->JUMLAH;
			}
			if ($checkjumlah > $jstok) {
				echo "stok kurang";
			}else {
				$tanggal = date("Y-m-d");
				$data = array (
					'KODE_RETURE'		=> $kode_kirim,
					'NAMA_RETURE'		=> $this->input->post('item'),
					'JUMLAH_RETURE'		=> $this->input->post('jumlah'),
					'TGL_RETURE'		=> $tanggal,
					'TOKO_RETURE'		=> $this->input->post('toko'),
					'BP_RETURE'			=> $this->input->post('bp'),
					'STATUS_RETURE'		=> $this->input->post('status')
				);


				$this->db->insert('tbl_reture', $data);
				redirect('Bp/update_item_reture/'.$kode_kirim);
			}
		}
		$data['code'] = $kode_kirim;
		$set = $this->db->query("SELECT * FROM tbl_permintaan WHERE KODE_PERMINTAAN = '$kode_kirim'");
		$data['tanda'] = $kode_item;
		echo $kode_item;
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_item");
		$data['cetak1'] = $this->M_item_reture->view_item_reture2($kode_kirim);
		$data['content'] = 'Bp/update_item_reture';

		$this->load->view('template', $data);
	}

	public function edit_item_reture2()
	{
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($jaga->result() as $key) {
			$tok = $key->ID_TOKO_JAGA;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$brg = $this->input->post('brg');
			$checkjumlah = $this->input->post('jumlah');
			$stock = $this->db->query("SELECT * FROM tbl_stok WHERE ID_BARANG = '$brg' AND ID_STORE = '$tok' LIMIT 1");
			foreach ($stock->result() as $key1) {
				$jstok = $key1->JUMLAH;
			}
			if ($checkjumlah > $jstok) {
				echo "stok kurang";
				$b = $this->input->post('kode_item');
				redirect('Bp/update_item_reture/'.$b);
			}else {
				$a = $this->input->post('id_item');
				$b = $this->input->post('kode_item');

				$data = array (
					'JUMLAH_RETURE'	=> $this->input->post('jumlah'),
				);

				$this->db->update('tbl_reture', $data, "ID_RETURE = '$a'");
				var_dump($a);

				redirect('Bp/update_item_reture/'.$b);
			}
		}
	}

	public function hapus_item_reture2($id,$kode_id)
	{
		$this->db->delete('tbl_reture', array('ID_RETURE' => $id));
		redirect('Bp/update_item_reture/'.$kode_id);
	}
	public function detail_item_reture($KODE_RETURE) {
		$data['deliv'] = $this->M_item_reture->find($KODE_RETURE);
		$data['cetak1'] = $this->M_item_reture->view_item_reture2($KODE_RETURE);
		$data['content'] = 'Bp/detail_item_reture';
		$this->load->view('template', $data);
	}

	public function view_item_sellout()
	{
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query(
			"SELECT * FROM tbl_penjaga
			WHERE NIP_JAGA = '$usr'
			LIMIT 1");
		$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
			foreach ($jaga->result() as $key) {
				$tok = $key->ID_TOKO_JAGA;
			}

		$data['cetak1'] = $this->M_sellout->view_item_sellout($tok);
		$data['content'] = 'Bp/view_item_sellout';
		$this->load->view('template', $data);
	}

	public function add_sellout_date()
	{
		 $tgl = $this->input->post('tgl');
		 $toko = $this->input->post('toko');

		$check = $this->db->query("SELECT * FROM tbl_laporan WHERE LAPORAN_DATE = '$tgl' AND TOKO_JUAL = '$toko' LIMIT 1")->num_rows();
		
		if ($check == 1) {
			echo "Tanggal Sudah pernah ditambahkan";
			redirect('Bp/view_item_sellout');
		
		}else {
			$data = array (
				'LAPORAN_DATE'		=> $this->input->post('tgl'),
				'TOKO_JUAL'		=> $this->input->post('toko'),
			);

			$this->db->insert('tbl_laporan', $data);
			redirect('Bp/add_sellout_item/'."$tgl");
		}

	}

	public function edit_item_sellout2($tanda)
	{
		$toko = $this->input->post('kode_item');
		$kode_lapor = $this->input->post('code');

		$data = array (

				'ID_LAPORAN' 	=> $this->input->post('id_item'),
				'ITEM_JUAL' 	=> $this->input->post('brg'),
				'HARGA_JUAL' 	=> $this->input->post('harga'),
				'JUMLAH_JUAL' 	=> $this->input->post('jumlah'),
			);

		$brg = $this->input->post('brg');
		$jumlah_post = $this->input->post('jumlah');
		$id_lapor = $this->input->post('id_item');

		$cek_stok = $this->M_sellout->cekstok($brg, $toko)->row()->JUMLAH;
		$cekstok = (int)$cek_stok;
		
		// echo $cekstok;

		$cek_jumlah = $this->M_sellout->cek_jumlah($brg, $id_lapor)->row()->JUMLAH_JUAL;

		if ($cek_jumlah > $jumlah_post) {
			
			$jumlah_update = $cek_jumlah - $jumlah_post;
			$perbarui_stok = $cekstok + $jumlah_update;


			$this->M_sellout->edit($tanda,$data);
			$this->M_stock->update_stok($perbarui_stok, $data['ITEM_JUAL'], $toko);
			// $this->M_stock->update_mutasi($perbarui_stok, $data['ITEM_JUAL'], $toko);
		
		} else if ($cek_jumlah < $jumlah_post) {
			
			$jumlah_update =  $jumlah_post - $cek_jumlah;
			$perbarui_stok = $cekstok - $jumlah_update;

			$this->M_sellout->edit($tanda,$data);
			$this->M_stock->update_stok($perbarui_stok,$data['ITEM_JUAL'],$toko);
		}

		// $this->M_sellout->edit($tanda,$data);
		redirect('Bp/add_sellout_item/'.$kode_lapor);

	}

	public function add_sellout_item($kode_lapor)
	{

		$data['code'] = $kode_lapor;

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tanggal = date("Y-m-d");
			$checkitem = $this->input->post('item');
			$data = array (

				'ID_LAPORAN'	=> $this->input->post('ai_lapor'),
				'ITEM_JUAL' 	=> $this->input->post('item'),
				'HARGA_JUAL' 	=> $this->input->post('harga'),
				'JUMLAH_JUAL' 	=> $this->input->post('jumlah'),
			);
			
			$set_ai_lapor = $this->input->post('ai_lapor');
			$brg = $this->input->post('item');
			$tok = $this->input->post('toko');
			$checkjumlah = $this->input->post('jumlah');
			$check = $this->db->query("SELECT * FROM tbl_isi_laporan WHERE ID_LAPORAN = '$set_ai_lapor' AND ITEM_JUAL = '$checkitem'");
			
			if ($check->num_rows() == 0) {

				$stock = $this->db->query("SELECT * FROM tbl_stok WHERE ID_BARANG = '$brg' AND ID_STORE = '$tok' LIMIT 1");

				foreach ($stock->result() as $key1) {
					$jstok = $key1->JUMLAH;
				}

					if ($checkjumlah > $jstok) {
						echo "string";
					}else{
						$this->db->insert('tbl_isi_laporan', $data);

						// --------- Update Stok --------

						$jumlahstok = $jstok - $checkjumlah;
						$this->M_stock->update_stok($jumlahstok,$brg,$tok);

						// ------------------------------

						date_default_timezone_set('Asia/Karachi'); # add your city to set local time zone
						$now = date('Y-m-d');
						$get_id = $this->M_stock->ambil_id()->result();
						$jumlah_stok = $this->M_stock->ambil_jumlah($brg, $tok)->row()->JUMLAH;
						$STOK_AWAL = $jumlah_stok + $checkjumlah;

						$data_mutasi = array (
							'ID_TOKO'			=> $tok,
							'ID_BARANG'			=> $brg,
							'STOK_AWAL'		  	=> $STOK_AWAL,
							'JUMLAH'		  	=> $checkjumlah,
							'STOK_AKHIR'		=> $jumlah_stok,
							'CREATED_AT'		=> $now,
							'STATUS'			=> 2
						);

						$this->db->insert('tbl_mutasi', $data_mutasi);

						// --
					}

			}else {
				$x = $this->input->post('id');
				$y = $this->input->post('jumlah');
				$this->db->query("UPDATE tbl_isi_laporan SET JUMLAH_JUAL = JUMLAH_JUAL + $y WHERE AI_ISI_LAPORAN = '$x'");
			}
			redirect('Bp/add_sellout_item/'.$kode_lapor);
		}

		$set = $this->db->query("SELECT * FROM tbl_laporan WHERE LAPORAN_DATE = '$kode_lapor'");
		foreach ($set->result() as $print) {
			$data['toko'] = $print->TOKO_JUAL;
			$data['ai_lapor'] = $print->AI_LAPORAN;
			$data['tgl_lapor'] = $print->LAPORAN_DATE;
		}

		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($jaga->result() as $key) {
			$tok = $key->ID_TOKO_JAGA;
		}
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_stok WHERE ID_STORE = '$tok' ");

		$data['cetak1'] = $this->M_sellout->view_item_sellout2($kode_lapor);

		$data['content'] = 'Bp/add_item_sellout';



		$this->load->view('template', $data);

	}

	public function update_item_sellout($tgl_lapor,$kode_lapor)
	{
		$data['tanda'] = 0;
		$data['code'] = $tgl_lapor;

		$set = $this->db->query("SELECT * FROM tbl_laporan WHERE LAPORAN_DATE = '$kode_lapor'");
		foreach ($set->result() as $print) {
			$data['toko'] = $print->TOKO_JUAL;
			$data['ai_lapor'] = $print->AI_LAPORAN;
			$data['tgl_lapor'] = $print->LAPORAN_DATE;
		}

		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($jaga->result() as $key) {
			$tok = $key->ID_TOKO_JAGA;
		}

		$set = $this->db->query("SELECT * FROM tbl_laporan WHERE LAPORAN_DATE = '$kode_lapor'");
		foreach ($set->result() as $print) {
			$data['toko'] = $print->TOKO_JUAL;
			$data['ai_lapor'] = $print->AI_LAPORAN;
			$data['tgl_lapor'] = $print->LAPORAN_DATE;
		}
		
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_stok WHERE ID_STORE = '$tok' ");
		$data['tanda'] = $kode_lapor;
		$data['cetak1'] = $this->M_sellout->view_item_sellout2($tgl_lapor);
		$data['content'] = 'Bp/update_item_sellout';
		$this->load->view('template', $data);
	}

	

	function cancel_sellout($id,$toko)
	{
		$kode_kirim = $this->uri->segment(3);
		$this->M_sellout->cancel_sellout($id,$toko) ;
		redirect('Bp/view_item_sellout');
	}

	public function hapus_item_sellout2($tgl,$ai_isi_lapor)
	{
		$ambil_brg = $this->M_sellout->ambil_nama($ai_isi_lapor)->row()->ITEM_JUAL;
		$usr = $this->session->userdata('nip');
		$jaga = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		foreach ($jaga->result() as $key) {
				$tok = $key->ID_TOKO_JAGA;
		}
		$cek = $this->M_sellout->cek($ai_isi_lapor)->row()->JUMLAH_JUAL;
		$cek_stok = $this->M_sellout->cekstok($ambil_brg, $tok)->row()->JUMLAH;
		$cekstok = (int)$cek_stok;

		$jumlah_update = $cek_stok + $cek;
		$this->M_stock->update_stok($jumlah_update,$ambil_brg,$tok);

		$this->db->delete('tbl_isi_laporan', array('AI_ISI_LAPORAN' => $ai_isi_lapor));
		redirect('Bp/add_sellout_item/'.$tgl);
	}


	public function view_monthly_report()
	{
		$data['content'] = 'bp/view_monthly_report';
		$this->load->view('template', $data);
	}

	public function excel_report()
	{	
		$tgl = $this->input->post('tgl');
		
		$user = $this->session->userdata('nip');
		$user_toko = $this->M_stock->select_toko($user)->row()->ID_TOKO_JAGA;
		$nama_bp = $this->M_stock->select_pegawai($user)->row()->NAMA_PEG;
		$nama_toko = $this->M_stock->select_nama_toko($user_toko)->row()->NAMA_TOKO;
		
		
		$this->load->library('excel'); 
	    $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        
        $objPHPExcel->getActiveSheet()->getStyle("B1:B2")->getFont()->setBold(true);
        
        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
            )
        );

        $noom = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
            )
        );


        $bulan = array (1 =>   'JANUARI',
			'FEBRUARI',
			'MARET',
			'APRIL',
			'MEI',
			'JUNI',
			'JULI',
			'AGUSTUS',
			'SEPTEMBER',
			'OKTOBER',
			'NOVEMBER',
			'DESEMBER'
		);

		$split = explode('-', $tgl);

        $objPHPExcel->getActiveSheet()->getStyle("A4:J5")
                ->applyFromArray($header);
        $objPHPExcel->getActiveSheet()->getStyle("L6:M6")
                ->applyFromArray($header);
        $objPHPExcel->getActiveSheet()->getStyle("L7:M8")
                ->applyFromArray($noom);

        $objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
        $objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
        $objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
        $objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
        $objPHPExcel->getActiveSheet()->mergeCells('F4:F5');
        $objPHPExcel->getActiveSheet()->mergeCells('J4:J5');
        $objPHPExcel->getActiveSheet()->mergeCells('G4:I4');
        $objPHPExcel->getActiveSheet()->mergeCells('L6:M6');
        $objPHPExcel->getActiveSheet()->mergeCells('L7:M8');
        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', 'Export Data dengan PHPExcel')
        	->setCellValue('B1', 'BP')
            ->setCellValue('B2', 'STORE')
            ->setCellValue('C1', $nama_bp)
            ->setCellValue('C2', $nama_toko)
            ->setCellValue('A4', 'No.')
            ->setCellValue('B4', 'DATE')
            ->setCellValue('C4', 'ARTICLE')
            ->setCellValue('D4', 'PRICE')
            ->setCellValue('E4', 'QTY')
            ->setCellValue('F4', 'NETT PRICE')
            ->setCellValue('G4', 'PEMBAYARAN')
            ->setCellValue('G5', 'DEBIT')
            ->setCellValue('H5', 'KREDIT')
            ->setCellValue('I5', 'CASH')
            ->setCellValue('J4', 'TOTAL')
            ->setCellValue('L6', 'NOMINAL');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        
        $no = 1;
        $counter = 6;
        $hasil = 0;

        $select_tgl_ai = $this->M_excel->select_tanggal($tgl,$user_toko)->result();
        foreach ($select_tgl_ai as $row) {
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->LAPORAN_DATE);
            $ai_lapor = $row->AI_LAPORAN;

            $select_isi = $this->M_excel->isi($ai_lapor)->result();
            foreach ($select_isi as $key) {
            	$kode_brg = $key->ITEM_JUAL;
            	$select_nama = $this->M_item->select_nama($kode_brg)->row()->NAMA_ITEM;
            	$ex->setCellValue('C'.$counter, $select_nama);
            	$price = $key->HARGA_JUAL;
            	$ex->setCellValue('D'.$counter, $price);
            	$qty = $key->JUMLAH_JUAL;
            	$ex->setCellValue('E'.$counter, $qty);
            	$ex->setCellValue('F'.$counter, $price);
            	$total = $price * $qty;
            	$ex->setCellValue('J'.$counter, $total);
            	$hasil = $hasil + $total;
            	$counter++;
            }

            $ex->setCellValue('J'.$counter, "-");
            $counter++;
        }

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L7', $hasil);
        
        $batas = $counter - 1;
        
        // KASIH CURRENCY

        $objPHPExcel->getActiveSheet()->getStyle('D6:D'.$batas)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $objPHPExcel->getActiveSheet()->getStyle('F6:F'.$batas)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $objPHPExcel->getActiveSheet()->getStyle('J6:J'.$batas)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $objPHPExcel->getActiveSheet()->getStyle('L7')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        // KASIH FILL

        $objPHPExcel->getSheet(0)->getStyle('A4:J5')->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getSheet(0)->getStyle('A4:J5')->getFill()
			->getStartColor()->setRGB('FFD700');

		$objPHPExcel->getSheet(0)->getStyle('B2:C2')->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getSheet(0)->getStyle('B2:C2')->getFill()
			->getStartColor()->setRGB('808000');
			
		$objPHPExcel->getSheet(0)->getStyle('B1:C1')->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getSheet(0)->getStyle('B1:C1')->getFill()
			->getStartColor()->setRGB('BDB76B');

		$select_tgl_ai = $this->M_excel->select_tanggal($tgl,$user_toko)->row();
		if ($select_tgl_ai != NULL) {
				$objPHPExcel->getSheet(0)->getStyle('J6:J'.$batas)->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getSheet(0)->getStyle('J6:J'.$batas)->getFill()
					->getStartColor()->setRGB('FFA07A');
			}
		$objPHPExcel->getSheet(0)->getStyle('L6:M6')->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getSheet(0)->getStyle('L6:M6')->getFill()
			->getStartColor()->setRGB('6B8E23');

		$objPHPExcel->getSheet(0)->getStyle('L7:M8')->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getSheet(0)->getStyle('L7:M8')->getFill()
			->getStartColor()->setRGB('90EE90');	

		// KASIH BORDER
		
		$objPHPExcel->getSheet(0)->getStyle('A4:J'.$batas)->getBorders()
			->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getSheet(0)->getStyle('A4:J'.$batas)->getBorders()
			->getAllBorders()->getColor()->setRGB('000000');

		$objPHPExcel->getSheet(0)->getStyle('L6:M8')->getBorders()
			->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getSheet(0)->getStyle('L6:M8')->getBorders()
			->getAllBorders()->getColor()->setRGB('000000');


        
        $objPHPExcel->getProperties()->setCreator("Ismo Broto")
            ->setLastModifiedBy("Ismo Broto")
            ->setTitle("Export PHPExcel Test Document")
            ->setSubject("Export PHPExcel Test Document")
            ->setDescription("Test doc for Office 2007 XLSX, generated by PHPExcel.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("PHPExcel");
        $objPHPExcel->getActiveSheet()->setTitle($bulan[ (int)$split[1] ] . ' ' . $split[0].'(SELL OUT)');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sellout'. date('Ymd') .'.xlsx"');
        
        $objWriter->save('php://output');
       
	}

	public function report_view()
	{
		$tgl = $this->input->post('tgl');
		$user = $this->session->userdata('nip');
		$user_toko = $this->M_stock->select_toko($user)->row()->ID_TOKO_JAGA;
		$nama_bp = $this->M_stock->select_pegawai($user)->row()->NAMA_PEG;
		$nama_toko = $this->M_stock->select_nama_toko($user_toko)->row()->NAMA_TOKO;

		$data['select_tgl_ai'] = $this->M_excel->select_tanggal($tgl,$user_toko)->result();

		$data['content'] = 'bp/view_monthly_report2';
		$this->load->view('template', $data);
	}

}
