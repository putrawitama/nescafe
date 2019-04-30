<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spv extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model(array('View_of','M_item_reture','M_news', 'M_stock'));

		if ($this->session->userdata('nip') == NULL){
            redirect('Controller_login');
        }
	}

	public function index()
	{
		date_default_timezone_set('Asia/Karachi'); # add your city to set local time zone
		$now = date('Y-m');
		$reture = $this->M_stock->retur_perbulan($now)->result();
		$kirim = $this->M_stock->pengiriman_perbulan($now)->result();
		$barang = $this->M_stock->total_barang_now()->row()->jumlah;
		// $grafik_barang = $this->M_stock->get_barang($now);

		$data['jumlah_reture'] = count($reture);
		$data['jumlah_kirim'] = count($kirim);
		$data['total_barang'] = $barang;
		// $data['grafik_barang'] = $grafik_barang;

		$data['now'] = $now;
		$data['content'] = 'spv/dasboard';
		$this->load->view('template', $data);
	}


	public function view_news()
	{
		$data['cetak1'] = $this->M_news->view_news();
		$data['content'] = 'spv/view_news';
		$this->load->view('template', $data);
	}

	public function add_news()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			
			$file = $this->input->post('judul');
			$config['file_name'] = $file;

			$data = array (
				'ID_BERITA'			=> '',
				'JUDUL_BERITA'		=> $this->input->post('judul'),
				'ISI_BERITA'		=> $this->input->post('isi'),
				'FOTO_BERITA'		=> $file.'.jpg'
			);
			
			$config['upload_path']          = './asset/berita/';
			$config['allowed_types']        = 'jpg';
			$config['max_size']             = 10000;

	 
			$this->load->library('upload', $config);

			$this->upload->do_upload('gambar');

			$this->db->insert('tbl_berita', $data);
			redirect('spv/view_news');
		}

		$data['kat'] = $this->db->query("SELECT * FROM tbl_berita");
		$data['content'] = 'spv/add_news';
		$this->load->view('template', $data);
	}



public function accepting_item_reture()
	{
		
		$data['cetak1'] = $this->M_item_reture->view_accepting_reture();
		$data['content'] = 'spv/view_accepting_item_reture';
		$this->load->view('template', $data);
	}

	public function accepting_item_reture2($kode_reture)
	{
		$usr = $this->session->userdata('nip');
		$test = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		
		foreach ($test->result_array() as $data) {
			$data1 = $data['ID_TOKO_JAGA'];

		}

		
	
			$kode = $kode_reture;

			$set = $this->db->query("SELECT * FROM tbl_reture WHERE KODE_RETURE = '$kode_reture' AND NAMA_RETURE IS NOT NULL ");
		
					foreach ($set->result_array() as $cetak1) {
					
							$ID_BARANG	= $cetak1['NAMA_RETURE'];
							$ID_STORE   = $cetak1['TOKO_RETURE'];
							echo 'id barang'.$ID_BARANG;

							 $test = $this->db->query("SELECT * FROM tbl_stok WHERE ID_BARANG = '$ID_BARANG' AND ID_STORE = '$ID_STORE'");
			

							 if ($test ->num_rows() > 0) {
						
										$data = array (
											'ID_BARANG'		=> $cetak1['NAMA_RETURE'],
											'JUMLAH'		=> $cetak1['JUMLAH_RETURE'],
											'ID_STORE'		=> $cetak1['TOKO_RETURE'],
										);
									
										$y = $data['JUMLAH'];
										$x = $data['ID_BARANG'];
										$z = $data['ID_STORE'];


										if ($x <> NULL AND $x <> '') {
											$sql= "UPDATE tbl_stok SET JUMLAH = JUMLAH - $y WHERE ID_BARANG = '$x' AND ID_STORE = '$z'";
											echo $sql;
											$result = $this->db->query($sql);


										}
							  		
							  }
							  var_dump($data);
							  // else{
									
									// 	$data = array (
									// 		'JUMLAH'		=> $cetak1['JUMLAH_PENGIRIMAN'],
									// 		'ID_BARANG'		=> $cetak1['NAMA_PENGIRIMAN'],
									// 		'ID_STORE'		=> $cetak1['TOKO_PENGIRIMAN'],
									// 	);
									// 	$x = $data['ID_BARANG'];
										
									// 	if ($x <> NULL AND $x <> '') {
									// 		$this->db->insert('tbl_stok', $data);
									// 	}							
							  // }
							 
				}
				
							$sql = "UPDATE tbl_reture
									SET STATUS_RETURE=2
									WHERE KODE_RETURE ='".$kode."'
									";

							$result = $this->db->query($sql);



					date_default_timezone_set('Asia/Karachi'); # add your city to set local time zone
					$now = date('Y-m-d');

					$get_id = $this->M_stock->ambil_id()->result();
					$jumlah_stok = $this->M_stock->ambil_jumlah($ID_BARANG, $ID_STORE)->row()->JUMLAH;
					$STOK_AWAL = $jumlah_stok + $cetak1['JUMLAH_RETURE'];

					$data_mutasi = array (
						'ID_TOKO'			=> $cetak1['TOKO_RETURE'],
						'ID_BARANG'			=> $cetak1['NAMA_RETURE'],
						'STOK_AWAL'		  	=> $STOK_AWAL,
						'JUMLAH'		  	=> $cetak1['JUMLAH_RETURE'],
						'STOK_AKHIR'		=> $jumlah_stok,
						'CREATED_AT'		=> $now,
						'STATUS'			=> 3
					);

					$this->db->insert('tbl_mutasi', $data_mutasi);
			redirect("Spv/accepting_item_reture");

	}

public function detail_item_reture($KODE_RETURE) {
		$data['deliv'] = $this->M_item_reture->find($KODE_RETURE);
		$data['cetak1'] = $this->M_item_reture->view_item_reture2($KODE_RETURE);
		$data['content'] = 'Spv/detail_item_reture';
		$this->load->view('template', $data);
	}


	public function view_report()
	{
		$this->load->view('template');
	}

	public function view_monthly_report()
	{
		$data['content'] = 'Spv/view_monthly_report';
		$this->load->view('template', $data);
	}	


	public function excel_report()
	{
		$tgl = $this->input->post('tgl');
		$query = $this->M_excel->export($tgl); 
		if(!$query)
            return false;
		
		 
        $this->load->library('excel');
        // $this->load->library('PHPExcel/IOFactory');		
		$object = new PHPExcel();
 
        $object->setActiveSheetIndex(0);
		 // Field names in the first row
        $fields = array("No","Nama Produk", "Stok Awal", "Barang Masuk", "Sell Out", "Retur", "Stok Akhir");
        $col = 0;
        foreach ($fields as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
		
		// Fetching the table data
        $cek_stat = $this->M_excel->export_satu($tgl)->result();
  //       foreach ($cek->result_array() as $d) {
		//  		$cek_stat	= $d['status'];
		// }

        $no = 1;
        $row = 2;
        

		foreach ($cek_stat as $data) {

			if ($data->status == "4") {
				
				continue;
			}

			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no++);     
	        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data->nama_item);
	        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $data->stok_awal);
	        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $row, ($data->status == "1") ? $data->jumlah : NULL);
	        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $row, ($data->status == "2") ? $data->jumlah : NULL);
	        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $row, ($data->status == "3") ? $data->jumlah : NULL);
	        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $data->stok_akhir);
	        	
			$row++;
		 
		// 
		}
        
		
		// $objPHPExcel->setActiveSheetIndex(0);
 
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Mutasi_'.date('dMy').'.xls"');
 
        $object_writer->save('php://output');
       
	}	
}
