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

                </div>
                <div class="box-footer">
                  <input type="button" class="btn btn-info pull-left" value="View Table" name="view" onclick="askForView()" />
                  <input type="button" class="btn btn-primary pull-right" value="Export" name="export" onclick="askForExport()" />
                </div>
              </form>
              
              <script>
                form = document.getElementById("report");
                function askForExport() {
                        form.action="<?= base_url('bp/excel_report')?>";
                        form.submit();
                }
                function askForView() {
                        form.action="<?= base_url('bp/report_view')?>";
                        form.submit();
                }   
              </script>

               <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Date</th>
                  <th>Article</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Nett Price</th>
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    $no = 1;
                    foreach($select_tgl_ai as $u){
                  ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $u->LAPORAN_DATE ?></td>
                    <?php 
                      $select_isi = $this->db->query("SELECT * FROM tbl_isi_laporan WHERE ID_LAPORAN = '$u->AI_LAPORAN' ");
                      
                      foreach ($select_isi->result() as $key) {
                        $select_nama = $this->db->query("SELECT * FROM tbl_item WHERE ID_ITEM = '$key->ITEM_JUAL' ");
                        $price = $key->HARGA_JUAL;
                        $qty = $key->JUMLAH_JUAL;
                        $total = $price * $qty;
                      
                        foreach ($select_nama->result() as $namas) {
                          $nama = $namas->NAMA_ITEM;
                        } ?>
            
                        <td> <?= $nama ?> </td>
                        <td> <?= $price ?> </td>
                        <td> <?= $qty ?> </td>
                        <td> <?= $price ?> </td>
                        <td> <?= $total ?> </td>                 
                    
                        <tr></tr>
                        <td> <?= "" ?> </td>
                        <td> <?= "" ?> </td>
                   
                      <?php } ?>

                    <td> <?= "" ?> </td>
                    <td> <?= "" ?> </td>
                    <td> <?= "" ?> </td>
                    <td> <?= "" ?> </td>
                    <td> <?= " - " ?> </td>

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
