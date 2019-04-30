



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Products List
        <small>Daftar produk</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Products</a></li>
        <li class="active">Products List</li>

      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Products List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Request Limit</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($cetak1 as $data1){?>
                  <tr>
                    <td><?= $data1->NAMA_KATEGORI?></td>
                    <td><?= $data1->BATAS_KIRIM?></td>
                    <td>
                      <!-- 'admin/products/edit/'.$product->pro_id, -->
                      <a href="<?php echo base_url(); ?>index.php/Admin/edit_category/<?php echo $data1->ID_KATEGORI; ?>" class="btn btn-primary">Edit</a>
                      <a href="<?php echo base_url(); ?>index.php/Admin/hapus_category/<?php echo $data1->ID_KATEGORI; ?>" class="btn btn-danger"> Delete </a>
                    </td>
                  </tr>
                <?php } ?>

                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
             <!-- /.box-body -->
              <div class="box-footer">
               <a href="<?php echo base_url(); ?>index.php/Admin/add_category" class="btn btn-info pull-right"> Add Category </a>
              </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

