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
