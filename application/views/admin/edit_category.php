



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
<div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Horizorm</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php foreach ($kategori->result() as $cetak){ ?>
            <?php $set = $cetak->ID_KATEGORI ;?>
            <form class="form-horizontal" action="<?= base_url('Admin/edit_category/'.$cetak->ID_KATEGORI)?>"
              enctype="multipart/form-data" method="post">



              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-8">

                    <input type="hidden" class="form-control" value="<?= $cetak->ID_KATEGORI ?>" name="code">
                    <input type="text" class="form-control" value="<?= $cetak->NAMA_KATEGORI ?>" name="nama">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Request Limit</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" value="<?= $cetak->BATAS_KIRIM ?>" name="batas">
                  </div>
                </div>
              </div>
            <?php } ?>


              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">SAVE ITEM</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
