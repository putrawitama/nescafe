<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
		function __construct(){
		parent::__construct();
		$this->load->model(array('View_of','M_brand_presenter','M_store','M_item_delivery','M_item_reture'));
	}
public function view_profile() {
	$files = glob('asset/temp/*');
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file);
			}
		}
		$nip = $this->session->userdata('nip');

		$data['cetak1'] =  $this->db->query("SELECT * FROM tbl_pegawai WHERE NIP = $nip ");

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
        WHERE NIP = '$nip'
        AND tbl_pegawai.NIP=tbl_penjaga.NIP_JAGA
        AND tbl_penjaga.ID_TOKO_JAGA=tbl_toko.ID_TOKO
        and tbl_pegawai.AKTIF='y'");
		$data['content'] = 'Settings/view_profile';
		$this->load->view('template', $data);
	}
	public function profile()
	{
		$files = glob('asset/temp/*');
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file);
			}
		}
		$nip = $this->session->userdata('nip');
		if ($this->input->server('REQUEST_METHOD') == 'POST') {


			$config['file_name'] = $nip;
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
			// 
			// echo $size."-";
			// echo $size2;

			if ($size == $size2) {
				$data = array (
					'NAMA_PEG'			=> $this->input->post('namapeg'),
					'ALAMAT_PEG'		=> $this->input->post('alamatpeg'),
					'EMAIL_PEG'			=> $this->input->post('emailpeg'),
					'TLP_PEG'				=> $this->input->post('tlppeg'),
					'JENIS_KELAMIN'	=> $this->input->post('kelaminpeg'),
					'TGL_LAHIR'			=> $this->input->post('tgllahirpeg'),
				);

				$this->db->update('tbl_pegawai', $data, "NIP = '$nip'");
			}else {
				rename('asset/temp/'.$nip.'.jpg', 'asset/user/'.$kode_gambar);
				rename('asset/user/'.$kode_gambar, 'asset/user/'.$nip.'.jpg');
				$data = array (
					'NAMA_PEG'			=> $this->input->post('namapeg'),
					'ALAMAT_PEG'		=> $this->input->post('alamatpeg'),
					'EMAIL_PEG'			=> $this->input->post('emailpeg'),
					'TLP_PEG'				=> $this->input->post('tlppeg'),
					'JENIS_KELAMIN'	=> $this->input->post('kelaminpeg'),
					'TGL_LAHIR'			=> $this->input->post('tgllahirpeg'),
					'FOTO_PEG'			=> $nip.'.jpg',
				);
				$this->db->update('tbl_pegawai', $data, "NIP = '$nip'");
				redirect('Settings/view_profile');
			}
		}

		$data['cetak1'] =  $this->db->query("SELECT * FROM tbl_pegawai WHERE NIP = $nip ");
		$data['content'] = 'Settings/edit_profile';
		$this->load->view('template', $data);
	}

}
