<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_sellout extends CI_Model{

  public function view_item_sellout($toko)
  {
   $sql = "SELECT AI_LAPORAN, LAPORAN_DATE , tbl_toko.NAMA_TOKO

          FROM tbl_laporan, tbl_toko
      --   AI_ISI_LAPORAN, AI_LAPORAN,
      --  tbl_isi_laporan.ID_LAPORAN AS ID_LAPORAN,
      --  -- tbl_isi_laporan.ITEM_JUAL AS ITEM_JUAL,
      --  tbl_isi_laporan.HARGA AS QTY,
      --  tbl_laporan.LAPORAN_DATE AS LAPORAN_DATE,
      --  tbl_laporan.TOKO_JUAL AS TOKO_JUAL
      --  FROM tbl_isi_laporan , tbl_laporan , tbl_toko
      -- WHERE tbl_laporan.TOKO_JUAL=tbl_toko.ID_TOKO
      -- AND tbl_laporan.AI_LAPORAN=tbl_isi_laporan.ID_LAPORAN
          WHERE tbl_laporan.TOKO_JUAL=tbl_toko.ID_TOKO
          AND tbl_laporan.TOKO_JUAL = '$toko'
      --   AND tbl_isi_laporan.ITEM_JUAL=tbl_item.ID_ITEM
        ";

    $result = $this->db->query($sql);
    return $result->result();
  }

  public function view_item_sellout2($kode_lapor)
   {
    $sql = "SELECT LAPORAN_DATE,AI_ISI_LAPORAN,ID_LAPORAN, ITEM_JUAL, HARGA_JUAL, JUMLAH_JUAL
        -- tbl_reture.ID_RETURE AS KODE_RETURE, ID_RETURE,

      FROM tbl_isi_laporan, tbl_laporan
      WHERE tbl_isi_laporan.ID_LAPORAN = tbl_laporan.AI_LAPORAN
          AND tbl_laporan.LAPORAN_DATE='$kode_lapor'
      ";

      $result = $this->db->query($sql);
      return $result->result();
   }

  public function find($KODE_RETURE){

         $sql = "SELECT
    tbl_reture.ID_RETURE,
    tbl_reture.KODE_RETURE,
    tbl_reture.NAMA_RETURE AS NAMA_RETURE,
    tbl_reture.JUMLAH_RETURE AS QTY,
    tbl_reture.TGL_RETURE AS TANGGAL,
    tbl_reture.STATUS_RETURE AS STATUS,
    tbl_reture.TOKO_RETURE,
    tbl_pegawai.NAMA_PEG,
    tbl_item.NAMA_ITEM AS ITEM,
    tbl_item.HARGA_ITEM AS HARGA,
    tbl_toko.NAMA_TOKO,
    tbl_toko.ALAMAT_TOKO,
    tbl_toko.TLP_TOKO,
    tbl_toko.EMAIL_TOKO
    FROM tbl_reture , tbl_item ,tbl_toko, tbl_pegawai
        WHERE tbl_reture.KODE_RETURE='$KODE_RETURE'
        AND tbl_reture.NAMA_RETURE=tbl_item.ID_ITEM
        AND tbl_reture.TOKO_RETURE=tbl_toko.ID_TOKO
        AND tbl_reture.BP_RETURE=tbl_pegawai.NIP
        ";

         $result = $this->db->query($sql);

        if ($result->num_rows() > 0 )
        {
          return $result->row();
        } else {
          return array();
        }
  }

  public function cancel_item_reture($kode_minta){
   $sql= "DELETE FROM tbl_reture WHERE KODE_RETURE ='$kode_minta'";
   $result = $this->db->query($sql);
  }
     
     function view_accepting_reture()
  {
     $this->db->select("*");
     $this->db->from("tbl_reture");
     $this->db->group_by("KODE_RETURE");
     $query = $this->db->get();
     return $query;
  }

  public function cancel_sellout($kode_minta,$toko_id){
   $sql= "DELETE FROM tbl_laporan WHERE LAPORAN_DATE ='$kode_minta' AND TOKO_JUAL = '$toko_id'";
   $result = $this->db->query($sql);
  }

  public function edit($tanda,$data)
  {
    
    $this->db->where('AI_ISI_LAPORAN',$tanda);
    $this->db->update('tbl_isi_laporan',$data);

  }

  public function cekstok($data,$toko)
  {
      
    $this->db->select("JUMLAH");
    $this->db->from("tbl_stok");
    $this->db->where("ID_BARANG", $data);
    $this->db->where("ID_STORE", $toko);
    $query = $this->db->get();
    return $query;
  }

  public function cek_jumlah($data,$id_lapor)
  {
    $this->db->select("JUMLAH_JUAL");
    $this->db->from("tbl_isi_laporan");
    $this->db->where("ITEM_JUAL", $data);
    $this->db->where("ID_LAPORAN", $id_lapor);
    $query = $this->db->get();
    return $query;
  }

  public function ambil_nama($ai_isi_lapor)
  {
    $this->db->select("ITEM_JUAL");
    $this->db->from("tbl_isi_laporan");
    $this->db->where("AI_ISI_LAPORAN", $ai_isi_lapor);
    $query = $this->db->get();
    return $query;
  }

  public function cek($ai_isi_lapor)
  {
    $this->db->select("JUMLAH_JUAL");
    $this->db->from("tbl_isi_laporan");
    $this->db->where("AI_ISI_LAPORAN", $ai_isi_lapor);
    $query = $this->db->get();
    return $query;
  }
}
