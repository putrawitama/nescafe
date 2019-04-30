<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model(array('View_of','M_item','M_item_request','M_category','M_employee','M_item_delivery','M_stock', 'M_excel'));
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pdf');

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
		$data['content'] = 'admin/dasboard';
		$this->load->view('template', $data);
	}

	public function view_item()
	{
		$data['cetak1'] = $this->M_item->view_item();
		$data['content'] = 'Admin/view_item';
		$this->load->view('template', $data);
	}

	public function add_item()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$file = $this->input->post('code');
			$config['file_name'] = $file;

			$data = array (
				'ID_ITEM'			=> $this->input->post('code'),
				'NAMA_ITEM'			=> $this->input->post('item'),
				'HARGA_ITEM'		=> $this->input->post('harga'),
				'FOTO_ITEM'			=> $file.'.jpg',
				'AI_PRODUK'			=> $this->input->post('kategori'),
				'AKTIF'				=> 'y'
			);

			$config['upload_path']          = './asset/item/';
			$config['allowed_types']        = 'jpg';
			$config['max_size']             = 10000;
			$this->load->library('upload', $config);
			$this->upload->do_upload('gambar');

			$this->db->insert('tbl_item', $data);
			redirect('admin/view_item');
		}

		$data['kat'] = $this->db->query("SELECT * FROM tbl_kategori");
		$data['content'] = 'Admin/add_item';
		$this->load->view('template', $data);
	}

	public function edit_item($kode_item)
	{
		$files = glob('asset/temp/*');
		foreach ($files as $file)
		{
			if (is_file($file)) {
				unlink($file);
			}
		}

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$file = $this->input->post('code');
			$config['file_name'] = $file;
			$kode_gambar = $this->input->post('gambarasli');

			$config['upload_path']          = './asset/temp/';
			$config['allowed_types']        = 'jpg';
			$config['max_size']             = 10000;
			$config['max_width']            = 10240;
			$config['max_height']           = 7680;
			$this->load->library('upload', $config);
			$this->upload->do_upload('gambar');
			$size = filesize("asset/item/$kode_gambar");
			$size2 = filesize("asset/temp/$kode_gambar");
			sleep(1);

			if ($size == $size2) {
				$data = array (
					'ID_ITEM'			=> $this->input->post('code'),
					'NAMA_ITEM'			=> $this->input->post('item'),
					'HARGA_ITEM'		=> $this->input->post('harga'),
					'AI_PRODUK'			=> $this->input->post('kategori')
				);
				$this->db->update('tbl_item', $data, "ID_ITEM = '$kode_item'");
			}else {
				rename('asset/temp/'.$file.'.jpg', 'asset/item/'.$kode_gambar);
				rename('asset/item/'.$kode_gambar, 'asset/item/'.$file.'.jpg');
				$data = array (
					'ID_ITEM'			=> $this->input->post('code'),
					'NAMA_ITEM'			=> $this->input->post('item'),
					'HARGA_ITEM'		=> $this->input->post('harga'),
					'FOTO_ITEM'			=> $file.'.jpg',
					'AI_PRODUK'			=> $this->input->post('kategori')
				);
				$this->db->update('tbl_item', $data, "ID_ITEM = '$kode_item'");
				redirect('admin/view_item/'.$file);
			}
			redirect('admin/view_item');
		}
		$data['kat'] = $this->db->query("SELECT * FROM tbl_kategori");
		$data['content'] = 'Admin/edit_item';
		$data['item'] = $this->db->query("SELECT * FROM tbl_item WHERE ID_ITEM = '$kode_item'");
		$this->load->view('template', $data);
	}

  function hapus_item()
	{
     $id = $this->uri->segment(3);
     $this->M_item->hapus_item($id) ;
        {
       		 redirect('admin/view_item');
        }
 	 }

	public function view_category()
		{
			$data['cetak1'] = $this->M_category->view_category();
			$data['content'] = 'Admin/view_category';
			$this->load->view('template', $data);
		}

		public function add_category()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$file = $this->input->post('code');
			
				$data = array (
					'ID_KATEGORI'		=> $this->input->post('code'),
					'NAMA_KATEGORI'		=> $this->input->post('nama'),
					'BATAS_KIRIM'		=> $this->input->post('batas'),
					'AKTIF'				=> 'y'
			);

			$this->db->insert('tbl_kategori', $data);
			redirect('admin/view_category');
		}
		$data['content'] = 'Admin/add_category';
		$this->load->view('template', $data);
	}

	public function edit_category($kode_category)
	{
		$files = glob('asset/temp/*');
		foreach ($files as $file)
		{
			if (is_file($file)) {
				unlink($file);
			}
		}

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$file = $this->input->post('code');
			
				$data = array (
					'ID_KATEGORI'		=> $this->input->post('code'),
					'NAMA_KATEGORI'		=> $this->input->post('nama'),
					'BATAS_KIRIM'		=> $this->input->post('batas'),
					
				);
				$this->db->update('tbl_kategori', $data, "ID_KATEGORI = '$kode_category'");
			
			redirect('admin/view_category');
		}
		$data['content'] = 'Admin/edit_category';
		$data['kategori'] = $this->db->query("SELECT * FROM tbl_kategori WHERE ID_KATEGORI = '$kode_category'");
		$this->load->view('template', $data);
	}

 function hapus_category()
	{
     $id = $this->uri->segment(3);
     $this->M_category->hapus_category($id) ;
        {
       		 redirect('admin/view_category');
        }
 	 }


	public function view_item_request()
	{
		$data['cetak1'] = $this->M_item_request->view_item_request();
		$data['content'] = 'Admin/view_item_request';
		$this->load->view('template', $data);
	}

	public function accepting_item_request()
	{
		
		$usr = $this->session->userdata('nip');
		$data['jaga'] = $this->db->query("SELECT * FROM tbl_penjaga WHERE NIP_JAGA = '$usr' LIMIT 1");
		$data['lastcode'] = $this->db->query("SELECT * FROM tbl_permintaan ORDER BY KODE_PERMINTAAN DESC LIMIT 1");
		$data['kat'] = $this->db->query("SELECT * FROM tbl_toko");
		// $data['bpkat'] = $this->db->query("SELECT * FROM tbl_pegawai WHERE LEVEL = 2 ");
		$data['cetak1'] = $this->M_item_request->view_item_request();
		$data['content'] = 'Admin/accepting_request';
		$this->load->view('template', $data);
	

	}


	public function accept_to_delive ($KODE_PERMINTAAN)
	{

		$set = $this->db->query("SELECT * FROM tbl_permintaan WHERE KODE_PERMINTAAN = '$KODE_PERMINTAAN' AND NAMA_PERMINTAAN IS NOT NULL ");
		// var_dump($set);
		
		date_default_timezone_set('Asia/Karachi'); # add your city to set local time zone
		$now = date('Y-m-d');


		$ambil_kode = $this->M_item_request->lastcode();

		$lastcode = $ambil_kode->KODE_PENGIRIMAN; 
		
	 
	    $a = 'MSD-SBY-DO-';
	    $b = date('Y-');
	    $c = '00';
	    $x = substr($lastcode,18);
	 
	    $kode = $a.$b.$c.($x+1);
		 
		 foreach ($set->result_array() as $data1) {
		 	$ID_BARANG	= $data1['NAMA_PERMINTAAN'];
			$ID_STORE   = $data1['TOKO_PERMINTAAN'];

		$data  = array(
			'KODE_PENGIRIMAN'		=> $kode,
			'NAMA_PENGIRIMAN'		=> $data1['NAMA_PERMINTAAN'],
			'JUMLAH_PENGIRIMAN'		=> $data1['JUMLAH_PERMINTAAN'],
			'TGL_PENGIRIMAN'		=> $now,
			'TOKO_PENGIRIMAN'		=> $data1['TOKO_PERMINTAAN'],
			'BP_PENGIRIMAN'			=> $data1['BP_PERMINTAAN'],
			'STATUS_PENGIRIMAN'		=> '3'

		);
		$this->db->insert('tbl_pengiriman', $data);

		// ------

		date_default_timezone_set('Asia/Karachi'); # add your city to set local time zone
		$now = date('Y-m-d');

		$get_id = $this->M_stock->ambil_id()->result();
		$jumlah_stok = $this->M_stock->ambil_jumlah($ID_BARANG, $ID_STORE)->row()->JUMLAH;
		$STOK_AWAL = $jumlah_stok - $data1['JUMLAH_PERMINTAAN'];

		$data_mutasi = array (
			'ID_TOKO'			=> $data1['TOKO_PERMINTAAN'],
			'ID_BARANG'			=> $data1['NAMA_PERMINTAAN'],
			'STOK_AWAL'		  	=> $STOK_AWAL,
			'JUMLAH'		  	=> $data1['JUMLAH_PERMINTAAN'],
			'STOK_AKHIR'		=> $jumlah_stok,
			'CREATED_AT'		=> $now,
			'STATUS'			=> 4
		);

		$this->db->insert('tbl_mutasi', $data_mutasi);

		// ------
	}

		$sql = "UPDATE tbl_permintaan
				SET STATUS_PERMINTAAN= 2
				WHERE KODE_PERMINTAAN ='".$KODE_PERMINTAAN."'
				";

		$result = $this->db->query($sql);

		
		redirect("Admin/accepting_item_request");
	}

	public function detail_item_request($KODE_PERMINTAAN) { 
		$data['deliv'] = $this->M_item_request->find($KODE_PERMINTAAN);
		$data['kode'] = $KODE_PERMINTAAN;
		$data['cetak1'] = $this->M_item_request->view_item_request2($KODE_PERMINTAAN);
		$data['content'] = 'Admin/detail_item_request';
		$this->load->view('template', $data);
	}


	public function view_employee()
	{
		$data['cetak1'] = $this->M_employee->view_employee();
		$data['content'] = 'Admin/view_employee';
		$this->load->view('template', $data);
	}

	public function add_employee()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$file = $this->input->post('nip');
			$config['file_name'] = $file;
			date_default_timezone_set('Asia/Karachi'); # add your city to set local time zone
			$now = date('Y-m-d');
			

			$data = array (
				'NIP'				=> $this->input->post('nip'),
				'NAMA_PEG'			=> $this->input->post('namapeg'),
				'PASSWORD'		  	=> $this->input->post('pass'),
				'LEVEL'				=> $this->input->post('level'),
				'ALAMAT_PEG'		=> $this->input->post('alamatpeg'),
				'EMAIL_PEG'			=> $this->input->post('emailpeg'),
				'TLP_PEG'			=> $this->input->post('tlppeg'),
				'JENIS_KELAMIN'		=> $this->input->post('kelaminpeg'),
				'TGL_LAHIR'			=> $now,
				'FOTO_PEG'			=> $file.'.jpg',
				'LEVEL'				=> $this->input->post('jabatan'),
				'AKTIF'				=> 'y'
			);
			$data2 = array (
				'NIP_JAGA'				=> $this->input->post('nip'),
				'ID_TOKO_jaga'			=> $this->input->post('toko')
				
			);
			

			$config['upload_path']          = './asset/user/';
			$config['allowed_types']        = 'jpg';
			$config['max_size']             = 10000;
			$this->load->library('upload', $config);
			$this->upload->do_upload('gambar');
			
			$this->db->insert('tbl_pegawai', $data);
			$this->db->insert('tbl_penjaga', $data2);

			redirect('admin/view_employee');
		}

		$data['kat'] = $this->db->query("SELECT * FROM tbl_toko");
		$data['content'] = 'Admin/add_employee';
		$this->load->view('template', $data);
	}

	public function edit_employee($kode_bp)
{
		$files = glob('asset/temp/*');
	foreach ($files as $file) {
		if (is_file($file)) {
			unlink($file);
		}
	}
	if ($this->input->server('REQUEST_METHOD') == 'POST') {
		$kode_bp = $this->input->post('nip');
		$file = $this->input->post('nip');
		$config['file_name'] = $file;
		$kode_gambar = $this->input->post('gambarasli');

		$config['upload_path']          = './asset/temp/';
		$config['allowed_types']        = 'jpg';
		$config['max_size']             = 10000;
		$config['max_width']            = 10240;
		$config['max_height']           = 7680;

		$this->load->library('upload', $config);

		$this->upload->do_upload('gambar');

		$size = filesize("asset/user/$kode_gambar");
		$size2 = filesize("asset/temp/$kode_gambar");
		sleep(1);

		echo $size."-";
		echo $size2;

		if ($size == $size2) {
			$data = array (
				'NIP'				=> $this->input->post('nip'),
				'NAMA_PEG'			=> $this->input->post('namapeg'),
				'PASSWORD'		  	=> $this->input->post('pass'),
				'LEVEL'				=> $this->input->post('level'),
				'ALAMAT_PEG'		=> $this->input->post('alamatpeg'),
				'EMAIL_PEG'			=> $this->input->post('emailpeg'),
				'TLP_PEG'			=> $this->input->post('tlppeg'),
				'JENIS_KELAMIN'		=> $this->input->post('kelaminpeg'),
				'TGL_LAHIR'			=> $this->input->post('tgllahirpeg'),
				'TGL_MASUK'			=> $this->input->post('tglmasuk'),
				'LEVEL'				=> $this->input->post('jabatan'),
				'AKTIF'				=> 'y'
			);
			$this->db->update('tbl_pegawai', $data, "NIP = '$kode_bp'");
		}else {
			rename('asset/temp/'.$file.'.jpg', 'asset/user/'.$kode_gambar);
			rename('asset/user/'.$kode_gambar, 'asset/user/'.$file.'.jpg');
			$data = array (
				'NIP'				=> $this->input->post('nip'),
				'NAMA_PEG'			=> $this->input->post('namapeg'),
				'PASSWORD'		  	=> $this->input->post('pass'),
				'LEVEL'				=> $this->input->post('level'),
				'ALAMAT_PEG'		=> $this->input->post('alamatpeg'),
				'EMAIL_PEG'			=> $this->input->post('emailpeg'),
				'TLP_PEG'			=> $this->input->post('tlppeg'),
				'JENIS_KELAMIN'		=> $this->input->post('kelaminpeg'),
				'TGL_LAHIR'			=>$this->input->post('tgllahirpeg'),
				'TGL_MASUK'			=> $this->input->post('tglmasuk'),
				'FOTO_PEG'			=> $file.'.jpg',
				'LEVEL'				=> $this->input->post('jabatan'),
				'AKTIF'				=> 'y'
			);


			$this->db->update('tbl_pegawai', $data, "NIP = '$kode_bp'");
			redirect('admin/view_employee/'.$file);
		}

		redirect('admin/view_employee');
	}
$data['tok'] = $this->db->query("SELECT tbl_pegawai.NIP AS NIP, 
 		tbl_pegawai.NAMA_PEG AS NAMA_PEG, 
 		tbl_pegawai.ALAMAT_PEG AS ALAMAT_PEG,
 		tbl_pegawai.TLP_PEG AS TLP_PEG,
 		tbl_pegawai.EMAIL_PEG AS EMAIL_PEG,
		tbl_pegawai.JENIS_KELAMIN AS JENIS_KELAMIN,
		tbl_pegawai.TGL_LAHIR AS TGL_LAHIR,
		tbl_toko.NAMA_TOKO AS NAMA_TOKO,
		tbl_pegawai.TGL_MASUK AS TGL_MASUK,
		tbl_pegawai.FOTO_PEG AS FOTO_PEG,
		tbl_pegawai.LEVEL AS LEVEL

 		FROM tbl_pegawai,tbl_penjaga,tbl_toko
        WHERE NIP = '$kode_bp'
        AND tbl_pegawai.NIP=tbl_penjaga.NIP_JAGA
        AND tbl_penjaga.ID_TOKO_JAGA=tbl_toko.ID_TOKO
        and tbl_pegawai.AKTIF='y'");
	$data['kat'] = $this->db->query("SELECT * FROM tbl_pegawai GROUP BY LEVEL" );
	$data['content'] = 'Admin/edit_employee';
	$data['bp'] = $this->db->query("SELECT * FROM tbl_pegawai WHERE NIP = '$kode_bp'");
	$this->load->view('template', $data);
}
function hapus_employee($NIP){
     $id = $this->uri->segment(3);
     $this->M_employee->hapus_employee($id) ;
        {
       		 redirect('admin/view_employee');
        }
    }

	public function detail_employee($NIP) {
$data['tok'] = $this->db->query("SELECT tbl_pegawai.NIP AS NIP, 
 		tbl_pegawai.NAMA_PEG AS NAMA_PEG, 
 		tbl_pegawai.ALAMAT_PEG AS ALAMAT_PEG,
 		tbl_pegawai.TLP_PEG AS TLP_PEG,
 		tbl_pegawai.EMAIL_PEG AS EMAIL_PEG,
		tbl_pegawai.JENIS_KELAMIN AS JENIS_KELAMIN,
		tbl_pegawai.TGL_LAHIR AS TGL_LAHIR,
		tbl_toko.NAMA_TOKO AS NAMA_TOKO,
		tbl_pegawai.TGL_MASUK AS TGL_MASUK,
		tbl_pegawai.FOTO_PEG AS FOTO_PEG,
		tbl_pegawai.LEVEL AS LEVEL

 		FROM tbl_pegawai,tbl_penjaga,tbl_toko
        WHERE NIP = '$NIP'
        AND tbl_pegawai.NIP=tbl_penjaga.NIP_JAGA
        AND tbl_penjaga.ID_TOKO_JAGA=tbl_toko.ID_TOKO
        and tbl_pegawai.AKTIF='y'");

		$data['bp'] = $this->M_employee->find($NIP);
		// $data['cetak1'] = $this->M_brand_presenter->detail_brand_presenter();
		$data['content'] = 'Admin/detail_employee';
		$this->load->view('template', $data);
	}

	public function add_code_delivery()
	{
			$data = array (
				'KODE_PENGIRIMAN'		=> $this->input->post('code'),
				'TGL_PENGIRIMAN'		=> $this->input->post('tgl'),
				'TOKO_PENGIRIMAN'		=> $this->input->post('toko'),
				'BP_PENGIRIMAN'			=> $this->input->post('bp'),
				'STATUS_PENGIRIMAN'		=> "1"
			);

			$this->db->insert('tbl_pengiriman', $data);
			redirect('admin/add_item_delivery/'.$this->input->post('code'));

	}
	public function view_item_delivery()
	{
		$data['lastcode'] = $this->db->query("SELECT * FROM tbl_pengiriman ORDER BY KODE_PENGIRIMAN DESC LIMIT 1");
		$data['kat'] = $this->db->query("SELECT * FROM tbl_toko");
		$data['bpkat'] = $this->db->query("SELECT * FROM tbl_pegawai WHERE LEVEL = 2 ");
		$data['cetak1'] = $this->M_item_delivery->view_item_delivery();
		$data['content'] = 'Admin/view_item_delivery';
		$this->load->view('template', $data);
	}

	public function add_item_delivery($kode_kirim)
	{
		$data['tanda'] = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tanggal = date("Y-m-d");
			$checkitem = $this->input->post('item');
			$data = array (
				'KODE_PENGIRIMAN'		=> $kode_kirim,
				'NAMA_PENGIRIMAN'		=> $this->input->post('item'),
				'JUMLAH_PENGIRIMAN'		=> $this->input->post('jumlah'),
				'TGL_PENGIRIMAN'		=> $tanggal,
				'TOKO_PENGIRIMAN'		=> $this->input->post('toko'),
				'BP_PENGIRIMAN'			=> $this->input->post('bp'),
				'STATUS_PENGIRIMAN'		=> "1"
			);

			$check = $this->db->query("SELECT * FROM tbl_pengiriman WHERE KODE_PENGIRIMAN = '$kode_kirim' AND NAMA_PENGIRIMAN = '$checkitem'");
			if ($check->num_rows() == 0) {
				$this->db->insert('tbl_pengiriman', $data);
			}else {
				$x = $this->input->post('id');
				$y = $this->input->post('jumlah');
				$this->db->query("UPDATE tbl_pengiriman SET JUMLAH_PENGIRIMAN = JUMLAH_PENGIRIMAN + $y WHERE ID_PENGIRIMAN = '$x'");
			}
			redirect('admin/add_item_delivery/'.$kode_kirim);
		}
		$data['code'] = $kode_kirim;
		$set = $this->db->query("SELECT * FROM tbl_pengiriman WHERE KODE_PENGIRIMAN = '$kode_kirim'");
		foreach ($set->result() as $print) {
			$data['bp'] = $print->BP_PENGIRIMAN;
			$data['toko'] = $print->TOKO_PENGIRIMAN;
		}
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_item");
		$data['cetak1'] = $this->M_item_delivery->view_item_delivery2($kode_kirim);
		$data['content'] = 'Admin/add_item_delivery';

		$this->load->view('template', $data);
	}

	public function hapus_item_delivery($id,$kode_id)
{
	$this->db->delete('tbl_pengiriman', array('ID_PENGIRIMAN' => $id));
	redirect('Admin/add_item_delivery/'.$kode_id);
}


public function edit_item_delivery()
{
	if ($this->input->server('REQUEST_METHOD') == 'POST') {
		$a = $this->input->post('id_item');
		$b = $this->input->post('kode_item');

		$data = array (
			'JUMLAH_PENGIRIMAN'	=> $this->input->post('jumlah'),
		);

		$this->db->update('tbl_pengiriman', $data, "ID_PENGIRIMAN = '$a'");
		var_dump($a);

	redirect('Admin/add_item_delivery/'.$b);
	}
}

	public function add_item_delivery2($kode_kirim,$kode_item)
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tanggal = date("Y-m-d");
			$data = array (
				'KODE_PENGIRIMAN'			=> $kode_kirim,
				'NAMA_PENGIRIMAN'		=> $this->input->post('item'),
				'JUMLAH_PENGIRIMAN'		=> $this->input->post('jumlah'),
				'TGL_PENGIRIMAN'		=> $tanggal,
				'TOKO_PENGIRIMAN'		=> $this->input->post('toko'),
				'BP_PENGIRIMAN'			=> $this->input->post('bp'),
				'STATUS_PENGIRIMAN'		=> $this->input->post('status')
			);


			$this->db->insert('tbl_pengiriman', $data);
			redirect('admin/add_item_delivery/'.$kode_kirim);
		}
		$data['code'] = $kode_kirim;
		$set = $this->db->query("SELECT * FROM tbl_pengiriman WHERE KODE_PENGIRIMAN = '$kode_kirim'");
		$data['tanda'] = $kode_item;
		foreach ($set->result() as $print) {
			$data['bp'] = $print->BP_PENGIRIMAN;
			$data['toko'] = $print->TOKO_PENGIRIMAN;
		}
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_item");
		$data['cetak1'] = $this->M_item_delivery->view_item_delivery2($kode_kirim);
		$data['content'] = 'Admin/add_item_delivery';

		$this->load->view('template', $data);
	}

	public function update_item_delivery($kode_kirim)
	{
		$data['tanda'] = 0;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tanggal = date("Y-m-d");
			$checkitem = $this->input->post('item');
			$data = array (
				'KODE_PENGIRIMAN'		=> $kode_kirim,
				'NAMA_PENGIRIMAN'		=> $this->input->post('item'),
				'JUMLAH_PENGIRIMAN'		=> $this->input->post('jumlah'),
				'TGL_PENGIRIMAN'		=> $tanggal,
				'TOKO_PENGIRIMAN'		=> $this->input->post('toko'),
				'BP_PENGIRIMAN'			=> $this->input->post('bp'),
				'STATUS_PENGIRIMAN'		=> "1"
			);

			$check = $this->db->query("SELECT * FROM tbl_pengiriman WHERE KODE_PENGIRIMAN = '$kode_kirim' AND NAMA_PENGIRIMAN = '$checkitem'");
			if ($check->num_rows() == 0) {
				$this->db->insert('tbl_pengiriman', $data);
			}else {
				$x = $this->input->post('id');
				$y = $this->input->post('jumlah');
				$this->db->query("UPDATE tbl_pengiriman SET JUMLAH_PENGIRIMAN = JUMLAH_PENGIRIMAN + $y WHERE ID_PENGIRIMAN = '$x'");
			}
			redirect('admin/update_item_delivery/'.$kode_kirim);
		}
		$data['code'] = $kode_kirim;
		$set = $this->db->query("SELECT * FROM tbl_pengiriman WHERE KODE_PENGIRIMAN = '$kode_kirim'");
		foreach ($set->result() as $print) {
			$data['bp'] = $print->BP_PENGIRIMAN;
			$data['toko'] = $print->TOKO_PENGIRIMAN;
		}
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_item");
		$data['cetak1'] = $this->M_item_delivery->view_item_delivery2($kode_kirim);
		$data['content'] = 'Admin/update_item_delivery';

		$this->load->view('template', $data);
	}

	public function update_item_delivery2($kode_kirim,$kode_item)
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$tanggal = date("Y-m-d");
			$data = array (
				'KODE_PENGIRIMAN'			=> $kode_kirim,
				'NAMA_PENGIRIMAN'		=> $this->input->post('item'),
				'JUMLAH_PENGIRIMAN'		=> $this->input->post('jumlah'),
				'TGL_PENGIRIMAN'		=> $tanggal,
				'TOKO_PENGIRIMAN'		=> $this->input->post('toko'),
				'BP_PENGIRIMAN'			=> $this->input->post('bp'),
				'STATUS_PENGIRIMAN'		=> $this->input->post('status')
			);


			$this->db->insert('tbl_pengiriman', $data);
			redirect('admin/update_item_delivery/'.$kode_kirim);
		}
		$data['code'] = $kode_kirim;
		$set = $this->db->query("SELECT * FROM tbl_pengiriman WHERE KODE_PENGIRIMAN = '$kode_kirim'");
		$data['tanda'] = $kode_item;
		foreach ($set->result() as $print) {
			$data['bp'] = $print->BP_PENGIRIMAN;
			$data['toko'] = $print->TOKO_PENGIRIMAN;
		}
		$data['itkat'] = $this->db->query("SELECT * FROM tbl_item");
		$data['cetak1'] = $this->M_item_delivery->view_item_delivery2($kode_kirim);
		$data['content'] = 'Admin/update_item_delivery';

		$this->load->view('template', $data);
	}

public function edit_item_delivery2()
{
	if ($this->input->server('REQUEST_METHOD') == 'POST') {
		$a = $this->input->post('id_item');
		$b = $this->input->post('kode_item');

		$data = array (
			'JUMLAH_PENGIRIMAN'	=> $this->input->post('jumlah'),
		);

		$this->db->update('tbl_pengiriman', $data, "ID_PENGIRIMAN = '$a'");
		var_dump($a);

	redirect('Admin/update_item_delivery/'.$b);
	}
}

public function hapus_item_delivery2($id,$kode_id)
{
	$this->db->delete('tbl_pengiriman', array('ID_PENGIRIMAN' => $id));
	redirect('Admin/update_item_delivery/'.$kode_id);
}
 function cencel_item_delivery($id)
	{
     $kode_kirim = $this->uri->segment(3);

     $this->M_item_delivery->cencel_item_delivery($kode_kirim) ;
        {
       		 redirect('admin/view_item_delivery');
        }
  }


	public function detail_item_delivery($KODE_PENGIRIMAN) {
		$data['deliv'] = $this->M_item_delivery->find($KODE_PENGIRIMAN);
		$data['kode'] = $KODE_PENGIRIMAN;
		$data['cetak1'] = $this->M_item_delivery->view_item_delivery2($KODE_PENGIRIMAN);
		$data['content'] = 'Admin/detail_item_delivery';
		$this->load->view('template', $data);
	}

	public function view_stock(){
		$data['a'] = 2;
		$data['cetak1'] = $this->M_stock->select_toko1();
		$data['content'] = 'Admin/view_stock';
		$this->load->view('template', $data);
	}

	public function view_stock_toko()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$data['cetak1'] = $this->M_stock->select_toko1();
			$data['kode_toko'] = $this->input->post('toko');
			$data['a'] = 0;
			$data['cetak2'] = $this->M_stock->view_all_stock($data['kode_toko']);
			$data['cetak4'] = $this->View_of->viewall("tbl_kategori");
			$data['cetak3'] = $this->M_stock->view_all_stock2($data['kode_toko']);
			$data['content'] = 'Admin/view_stock';
			$this->load->view('template', $data);
		}

	}

	public function view_monthly_report()
	{
		$data['toko'] = $this->M_excel->ambil_toko()->result(); 
		$data['a'] = 2;
		$data['content'] = 'Admin/view_monthly_report';
		$this->load->view('template', $data);
	}

	public function view_monthly_report2()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$data['toko'] = $this->M_excel->ambil_toko()->result();
			$data['a'] = 0; 
			$tgl = $this->input->post('tgl');
		 	$toko = $this->input->post('ID_TOKO'); 
		 	$nama_toko = $this->M_excel->ambil_nama_toko($toko)->row()->NAMA_TOKO; 
			
			$data['cetak3'] = $this->M_excel->ambil_nama_toko($data['ID_TOKO']); 
 
			$data['cetak2'] = $this->M_excel->export_satu($tgl,$toko);
			$data['content'] = 'Admin/view_monthly_report';
			$this->load->view('template', $data);
		}

	}


	public function excel_report()
	{
		$tgl = $this->input->post('tgl');
		$toko = $this->input->post('ID_TOKO');
		$nama_toko = $this->M_excel->ambil_nama_toko($toko)->row()->NAMA_TOKO; 
		// $query = $this->M_excel->export($tgl,$toko); 
		// if(!$query)
  //           return false;
		
		 
        $this->load->library('excel');
        // $this->load->library('PHPExcel/IOFactory');		
		$object = new PHPExcel();
		
		$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

        $object->getActiveSheet()->getStyle(6)->getFont()->setBold(true);
        
        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true
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


        // ubah warna kolom

		// $object->getActiveSheet()->getStyle('A5:G5')->getFill()
		// 		->setFillType(PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR);
		// $object->getActiveSheet()->getStyle('A5:G5')->getFill()
		// 		->getStartColor()->setRGB('F78B9D');
		// $object->getActiveSheet()->getStyle('A5:G5')->getFill()
		// 		->getEndColor()->setRGB('F78B9D');


        $object->getActiveSheet()->getStyle("A1:G1")
                ->applyFromArray($header);
        $object->getActiveSheet()->getStyle("A2:G2")
                ->applyFromArray($header);
        $object->getActiveSheet()->getStyle("A3:G3")
        		->applyFromArray($header);
        $object->getActiveSheet()->getStyle("A5:G5")
		        ->applyFromArray($header);

        $object->getActiveSheet()->mergeCells('A1:G1');
        $object->getActiveSheet()->mergeCells('A2:G2');
        $object->getActiveSheet()->mergeCells('A3:G3');
        $object->getActiveSheet()->mergeCells('A5:G5');
        
        $object->setActiveSheetIndex(0)
		 // Field names in the first row

        ->setCellValue('A1', 'LAPORAN PENJUALAN DAN STOK')
        ->setCellValue('A2', 'NESCAFE DOLCE GUSTO')
        ->setCellValue('A3', $nama_toko)
        ->setCellValue('A5', $bulan[ (int)$split[1] ] . ' ' . $split[0]);


        $fields = array("No","Nama Produk", "Stok Awal", "Barang Masuk", "Sell Out", "Retur", "Stok Akhir");
        $col = 0;
        foreach ($fields as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($col, 6, $field);
            $col++;
        }
		
		// Fetching the table data
        
        $no = 1;
        $row = 7;
       
        $ambil_brg = $this->M_excel->ambil_nama()->result();

		foreach ($ambil_brg as $data) {

			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no++);     
	        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $data->NAMA_ITEM);
	        
	        $tgl = $this->input->post('tgl');
			$toko = $this->input->post('ID_TOKO');
	        $nama = $data->NAMA_ITEM;
	        $id_brg = $this->M_excel->ambil_id($nama)->row()->ID_ITEM;
	        
	        // ----------------------------------------------------------------------
	        $cek_stok_awal = $this->M_excel->cek_stok($id_brg,$toko,$tgl)->row();
	        if ($cek_stok_awal == NULL) {
	        	# code...
	        	$object->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 0);
	        }

	        $awal_stok = $this->M_excel->ambil_stok($id_brg,$toko,$tgl)->result();
	        foreach ($awal_stok as $datas) {
	   			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $datas->stok_awal);
	        }
	        
	        // ----------------------------------------------------------------------
	        $jumlah_masuk = $this->M_excel->ambil_jumlah_masuk($id_brg,$toko,$tgl)->row()->jumlah;
	        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $row, ($jumlah_masuk != NULL) ? $jumlah_masuk : 0);

			// ----------------------------------------------------------------------
	        $jumlah_sell = $this->M_excel->ambil_jumlah_sell($id_brg,$toko,$tgl)->row()->jumlah;
	        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $row, ($jumlah_sell != NULL) ? $jumlah_sell : 0);

	        // ----------------------------------------------------------------------
	        $jumlah_retur = $this->M_excel->ambil_jumlah_retur($id_brg,$toko,$tgl)->row()->jumlah;
	        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $row, ($jumlah_retur != NULL) ? $jumlah_retur : 0);

	        // ----------------------------------------------------------------------
	        $cek_stok_akhir = $this->M_excel->cek_stok_akhir($id_brg,$toko,$tgl)->row();
	        if ($cek_stok_akhir == NULL) {
	        	# code...
	        	$object->getActiveSheet()->setCellValueByColumnAndRow(6, $row, 0);
	        }

	        $akhir_stok = $this->M_excel->ambil_stok_akhir($id_brg,$toko,$tgl)->result();
	        foreach ($akhir_stok as $datas) {
	   			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $datas->stok_akhir);
	        }
	        	
			$row++;
		  
		}
        
		
		// $objPHPExcel->setActiveSheetIndex(0);
 
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Mutasi_'.date('dMy').'.xls"');
 
        $object_writer->save('php://output');
       
	}

	public function report_view()
	{
		$data['toko'] = $this->M_excel->ambil_toko()->result();
		$data['ambil_brg'] = $this->M_excel->ambil_nama()->result();
	    $data['tgl'] = $this->input->post('tgl');
		$data['tok'] = $this->input->post('ID_TOKO');

		$data['content'] = 'Admin/view_monthly_report2';
		$this->load->view('template', $data);
	}
	
	public function cetak_pdf($kode)
	{
        $pdf = new FPDF('l','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(200,6,'DELIVERY ORDER',0,1,'C');
        
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(200,8,'SURAT JALAN',0,1,'C');

        // GARIS BAWAH
        $pdf->SetDrawColor(188,188,188);
		$pdf->Line(10,28,200,28);
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,6,'',0,1);

        // --------------------------------------------------------//
        $deliv = $this->M_item_delivery->find($kode);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,5,'No',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$kode,0,1);

        $pdf->Cell(30,5,'Date / Tanggal',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$deliv->TANGGAL,0,1);

        $pdf->Cell(30,5,'To / Tujuan',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$deliv->NAMA_TOKO,0,1);

        $pdf->Cell(30,5,'',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$deliv->ALAMAT_TOKO,0,1);

        $pdf->Cell(30,5,'Brand Presenter',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$deliv->NAMA_PEG,0,1);

        // --------------------------------------------------------//
        $pdf->Cell(10,4,'',0,1);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(17,6,'NO',1,0,'C');
        $pdf->Cell(60,6,'Product Code / Kode Produk',1,0,'C');
        $pdf->Cell(90,6,'Product Name / Nama Produk',1,0,'C');
        $pdf->Cell(23,6,'QTY',1,1,'C');
        
        $pdf->SetFont('Arial','',10);
        $total = 0;
        $no = 1;
        $cetak1 = $this->M_item_delivery->view_item_delivery2($kode);
        foreach ($cetak1 as $row){
            $pdf->Cell(17,7,$no++,0,0,'C');
            $pdf->Cell(60,7,$row->NAMA_PENGIRIMAN,0,0,'C');
            $pdf->Cell(90,7,$row->ITEM,0,0,'C');
            $pdf->Cell(23,7,$row->QTY,0,1,'C');
            $total = $total + $row->QTY;
        }

        $pdf->SetDrawColor(188,188,188);
		$pdf->Line(10,59,10,128);
		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(27,59,27,128);
		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(87,59,87,128);
		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(177,59,177,122);
		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(200,59,200,122);

		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(10,128,200,128);
		// $pdf->SetDrawColor(188,188,188);
		// $pdf->Line(10,130,200,130);

		$pdf ->SetY(122);
		$pdf->SetFont('Arial','B',11);
        $pdf->Cell(17,6,'',0,0,'C');
        $pdf->Cell(60,6,'',0,0);
        $pdf->Cell(90,6,'TOTAL : ',1,0,'C');
        $pdf->Cell(23,6,$total,1,1,'C');

        $pdf->Output();
    }

    public function cetak_req_pdf($kode)
	{
        $pdf = new FPDF('l','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(200,6,'REQUEST ORDER',0,1,'C');
        
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(200,8,'SURAT JALAN',0,1,'C');

        // GARIS BAWAH
        $pdf->SetDrawColor(188,188,188);
		$pdf->Line(10,28,200,28);
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,6,'',0,1);

        // --------------------------------------------------------//
        $deliv = $this->M_item_request->find($kode);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,5,'No',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$kode,0,1);

        $pdf->Cell(30,5,'Date / Tanggal',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$deliv->TANGGAL,0,1);

        $pdf->Cell(30,5,'To / Tujuan',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$deliv->NAMA_TOKO,0,1);

        $pdf->Cell(30,5,'',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$deliv->ALAMAT_TOKO,0,1);

        $pdf->Cell(30,5,'Brand Presenter',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(10,5,$deliv->NAMA_PEG,0,1);

        // --------------------------------------------------------//
        $pdf->Cell(10,4,'',0,1);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(17,6,'NO',1,0,'C');
        $pdf->Cell(60,6,'Product Code / Kode Produk',1,0,'C');
        $pdf->Cell(90,6,'Product Name / Nama Produk',1,0,'C');
        $pdf->Cell(23,6,'QTY',1,1,'C');
        
        $pdf->SetFont('Arial','',10);
        $total = 0;
        $no = 1;
        $cetak1 = $this->M_item_request->view_item_request2($kode);
        foreach ($cetak1 as $row){
            $pdf->Cell(17,7,$no++,0,0,'C');
            $pdf->Cell(60,7,$row->NAMA_PERMINTAAN,0,0,'C');
            $pdf->Cell(90,7,$row->ITEM,0,0,'C');
            $pdf->Cell(23,7,$row->QTY,0,1,'C');
            $total = $total + $row->QTY;
        }

        $pdf->SetDrawColor(188,188,188);
		$pdf->Line(10,59,10,128);
		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(27,59,27,128);
		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(87,59,87,128);
		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(177,59,177,122);
		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(200,59,200,122);

		$pdf->SetDrawColor(188,188,188);
		$pdf->Line(10,128,200,128);
		// $pdf->SetDrawColor(188,188,188);
		// $pdf->Line(10,130,200,130);

		$pdf ->SetY(122);
		$pdf->SetFont('Arial','B',11);
        $pdf->Cell(17,6,'',0,0,'C');
        $pdf->Cell(60,6,'',0,0);
        $pdf->Cell(90,6,'TOTAL : ',1,0,'C');
        $pdf->Cell(23,6,$total,1,1,'C');

        $pdf->Output();
    }
}
