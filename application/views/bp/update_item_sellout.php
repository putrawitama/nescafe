



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
<div class="col-md-4">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <form class="form-horizontal" action="<?= base_url('Bp/add_sellout_item/'.$code)?>"
              enctype="multipart/form-data" method="post">
            <div class="box-header with-border">
              <h3 class="box-title">TANGGAL LAPORAN :</h3>
              <input type="text" class="form-control" value="<?= $code?>" name="code" readonly>
              <?php foreach ($jaga->result() as $cetak3){ ?>
                <input type="hidden" class="form-control" value="<?= $cetak3->NIP_JAGA?>" name="bp">
                <input type="hidden" class="form-control" value="<?= $cetak3->ID_TOKO_JAGA?>" name="toko">
              <?php } ?>

              <?php foreach($cetak1 as $data2){?>
                <input type="hidden" name="id" value="<?= $data2->AI_ISI_LAPORAN?>">
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->


              <div class="box-body">

              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Product Name</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="item" required="">
                      <option></option>
                      <?php foreach($itkat->result_array() as $itcat){ ?>
                        <option value="<?= $itcat['ID_BARANG'] ?>"><?= $itcat['ID_BARANG'] ?> -- > <?= $itcat['JUMLAH'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Harga
                    (Toko)</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="harga" name="harga" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">qty</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="qty" name="jumlah" required>
                  </div>
                </div>


              </div>

              <!-- /.box-body -->
              <div class="box-footer">

                <button type="submit" class="btn btn-info pull-right">ADD ITEM</button>
              </div>


              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->

          <!-- /.box -->
        </div>
<div class="col-md-8" >
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Table With Full Features</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Item Jual</th>
          <th>Harga Jual</th>
          <th>Jumlah Jual</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
          <?php $HARGA_JUALtotal = 0 ; $jumlahtotal = 0 ;$total = 0 ?>
          <?php $toko = $cetak3->ID_TOKO_JAGA; ?>
          <?php foreach($cetak1 as $data1){?>


            <?php
              $HARGA_JUALtotal += $data1->HARGA_JUAL;
              $jumlahtotal += $data1->JUMLAH_JUAL;
              $total += $data1->JUMLAH_JUAL*$data1->HARGA_JUAL;
              $tot = $data1->JUMLAH_JUAL*$data1->HARGA_JUAL;
              
            ?>
          <?php if ($tanda == $data1->AI_ISI_LAPORAN) { ?>

              <tr>
                <form class="form-horizontal" action="<?= base_url('Bp/edit_item_sellout2/'. $tanda)?>" method="post">
                <td><?= $data1->ITEM_JUAL?></td>
                 <td><?= $data1->HARGA_JUAL?></td>
                <td>
                  <input type="text" class="form-control" value="<?= $data1->JUMLAH_JUAL?>" name="jumlah" maxlength="4" size="4">
                  <input type="hidden" class="form-control" value="<?= $data1->ID_LAPORAN?>" name="id_item">
                  <input type="hidden" class="form-control" value="<?= $cetak3->ID_TOKO_JAGA?>" name="kode_item">
                  <input type="hidden" class="form-control" value="<?= $code?>" name="code">
                  <input type="hidden" class="form-control" value="<?= $tanda?>" name="ai_laporan">
                  <input type="hidden" class="form-control" value="<?= $data1->HARGA_JUAL?>" name="harga">
                  <input type="hidden" class="form-control" value="<?= $data1->ITEM_JUAL?>" name="brg">
                </td>
                <!-- <td></td> -->
               <td>
                  <input type="submit" value="Save" class="btn btn-primary"></input>
                  <a href="<?= base_url("Bp/hapus_item_sellout2/$code/$data1->ID_LAPORAN")?>" class="btn btn-danger small">Hapus</a>

                </td>
                <!-- <td></td> -->
                </form>
              </tr>

          <?php  }else { ?>
            <tr>
              <td><?= $data1->ITEM_JUAL ?></td>
              <td><?= $data1->HARGA_JUAL?></td>
              <td><?= $data1->JUMLAH_JUAL?></td>
              <!-- <td></td> -->
              <td><a href="<?= base_url("Bp/update_item_sellout/$code/$data1->AI_ISI_LAPORAN")?>" class="btn btn-primary small">Edit</a>
                  <a href="<?= base_url("Bp/hapus_item_sellout2/$code/$data1->ID_LAPORAN")?>" class="btn btn-danger small">Delete</a></td>
            </tr>
          <?php } ?>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
          <th>TOTAL </th>
          <th></th>
          <th><?= $jumlahtotal?></th>
         <th></th>
        </tr>

        </tfoot>
      </table>


           <a href="<?php echo base_url('Bp/view_item_sellout'); ?>" class="btn btn-success pull-right">Done</a>

              </div>


    <!-- /.box-body -->
  </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>





  <!-- Content Wrapper. Contains page content -->
