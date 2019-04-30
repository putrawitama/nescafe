  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
                <form class="form-horizontal" id="report" action="" method="post">
                <div class="box-body">
                 
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Bulan dan Tahun : </label>
                    <div class="col-sm-8">
                      <input type="month" class="form-control" name="tgl" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Toko : </label>
                    <div class="col-sm-8">
                      <select name="ID_TOKO" class="form-control" >
                              <?php foreach($toko as $select){ ?>

                            <option value="<?php echo $select->ID_TOKO ?>"
                              > <?php echo $select->NAMA_TOKO ?> </option>
                            <?php } ?>            
                      </select>
                    </div>
                  </div>

                </div>
                <div class="box-footer">
                  <input type="button" class="btn btn-info pull-left" value="View Table" name="view" onclick="askForView()" />
                  <input type="button" class="btn btn-primary pull-right" value="Export" name="export" onclick="askForExport()" />
                </div>
              </form>
              
              <script>
                form = document.getElementById("report");
                function askForExport() {
                        form.action="<?= base_url('admin/excel_report')?>";
                        form.submit();
                }
                function askForView() {
                        form.action="<?= base_url('admin/report_view')?>";
                        form.submit();
                }   
              </script>

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Produk</th>
                  <th>Stok Awal</th>
                  <th>Barang Masuk</th>
                  <th>Sell Out</th>
                  <th>Retur</th>
                  <th>Stok Akhir</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    $no = 1;
                    foreach($ambil_brg as $u){
                  ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $u->NAMA_ITEM ?></td>
                    
                    <?php 
                      $id_barang = $this->db->query("SELECT ID_ITEM FROM tbl_item WHERE NAMA_ITEM = '$u->NAMA_ITEM'");
                      $id_brg = $id_barang->row()->ID_ITEM;
                      //--------------------------------------------------------------------------------------------
                      $awal_stok = $this->db->query("SELECT stok_awal FROM tbl_mutasi WHERE id_barang = '$id_brg' 
                      AND id_toko = '$tok' AND created_at LIKE '%$tgl%' ORDER BY id_mutasi ASC LIMIT 1");
                      $cek = $awal_stok->row();              
                      foreach ($awal_stok->result() as $aw ) { 
                          $awal = $aw->stok_awal;
                      } ?>
                      <td><?= ($cek != NULL) ? $awal : 0 ?></td>

                    <?php
                      $jumlah_masuk = $this->db->query("SELECT jumlah FROM tbl_mutasi WHERE id_barang = '$id_brg' 
                      AND id_toko = '$tok' AND created_at LIKE '%$tgl%' AND status = 1");
                      $cek_in = $jumlah_masuk->row(); 
                      foreach ($jumlah_masuk->result() as $in ) { 
                          $masuk = $in->jumlah;
                      } ?>
                      <td><?= ($cek_in != NULL) ? $masuk : 0 ?></td>

                    <?php
                      $jumlah_sell = $this->db->query("SELECT jumlah FROM tbl_mutasi WHERE id_barang = '$id_brg' 
                      AND id_toko = '$tok' AND created_at LIKE '%$tgl%' AND status = 2");
                      $cek_out = $jumlah_sell->row(); 
                      foreach ($jumlah_sell->result() as $out ) { 
                          $sell = $out->jumlah;
                      } ?>
                      <td><?= ($cek_out != NULL) ? $sell : 0 ?></td>

                    <?php
                      $jumlah_reture = $this->db->query("SELECT jumlah FROM tbl_mutasi WHERE id_barang = '$id_brg' 
                      AND id_toko = '$tok' AND created_at LIKE '%$tgl%' AND status = 3");
                      $cek_back = $jumlah_reture->row(); 
                      foreach ($jumlah_reture->result() as $back) { 
                          $reture = $back->jumlah;
                      } ?>
                      <td><?= ($cek_back != NULL) ? $reture : 0 ?></td>

                    <?php
                      $akhir_stok = $this->db->query("SELECT stok_akhir FROM tbl_mutasi WHERE id_barang = '$id_brg' 
                      AND id_toko = '$tok' AND created_at LIKE '%$tgl%' ORDER BY id_mutasi DESC LIMIT 1");
                      $cek_akhir = $akhir_stok->row();              
                      foreach ($akhir_stok->result() as $akh ) { 
                          $akhir = $akh->stok_akhir;
                      } ?>
                      <td><?= ($cek_akhir != NULL) ? $akhir : 0 ?></td>
                
                  </tr>
                <?php } ?>
                </tbody>
                <tfoot>
               
                </tfoot>
              </table>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>