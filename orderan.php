<?php 
   session_start();
   require 'koneksi.php';
   require 'function.php';
   include 'header.php';
   $now = date("Y-m-d");

   #selesaikan orderan
   if(isset($_POST['btnselesaikan'])) {
    $id_trx = pilter($kon,$_POST['id_trx']);
    $sql = "UPDATE invoice SET status='Selesai' WHERE id_trx=?";
    $stmt = mysqli_prepare($kon, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id_trx);
    mysqli_stmt_execute($stmt);
   }

   #lakukan void 
   if(isset($_POST['btnvoid'])) {
      $id_trx = pilter($kon,$_POST['id_trx']);

      //ubah keterangan void menjadi ya
      $sql = "UPDATE invoice SET void='ya' WHERE id_trx=?";
      $stmt = mysqli_prepare($kon,$sql);
      mysqli_stmt_bind_param($stmt,"s",$id_trx);
      mysqli_stmt_execute($stmt);

      // ubah status dari proses ke batal
      $sql = "UPDATE invoice SET status='Batal' WHERE id_trx=?";
      $stmt = mysqli_prepare($kon,$sql);
      mysqli_stmt_bind_param($stmt,"s",$id_trx);
      mysqli_stmt_execute($stmt);

   }
   
?>

<?php include 'navbar.php' ?>

<div class="container-fluid mt-3 mb-5">

    <div class="row">
        <div class="col lg-6">
            <div class="card card-body card-round">
            <div class="alert alert-warning">Hanya menampilkan Orderan hari ini harap download ke excel ketika tutup toko! </div>
               <table class="table" id="datatable">
                  <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Idinv</th>
                        <th>Cashier</th>
                        <th>Nama</th>
                        <th>Meja</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     $d_invoice = mysqli_query($kon,"SELECT * FROM invoice WHERE resto='$_SESSION[resto]' AND tanggal='$now' ORDER BY id DESC ");
                     while($l_invoice = mysqli_fetch_array($d_invoice))  {
                    ?>
                    <tr>
                        <td><?= $l_invoice['tanggal'] ?></td>
                        <td>#<?= $l_invoice['id_trx']?></td>
                        <td><?= $l_invoice['cashier']?></td>
                        <td><?= $l_invoice['nama']?></td>
                        <td><?= $l_invoice['meja']?></td>
                        <td><?= $l_invoice['total']?></td>
                        <td>
                             <?php if($l_invoice['status'] === 'Proses' && $l_invoice['void'] === 'tidak') { ?>
                                <button class="btn btn-warning" data-toggle="modal" data-target="#selesaiModal<?= $l_invoice['id_trx']?>">Selesaikan</button>      
                             <?php } else if ($l_invoice['status'] === 'Proses' && $l_invoice['void'] === 'ya') {  ?>
                                <button class="btn btn-danger" disabled>Divoid</button>     
                             
                             <?php } else if ($l_invoice['status'] === 'Batal' && $l_invoice['void'] === 'ya') {  ?>
                                <button class="btn btn-danger" disabled>Divoid</button>  
                             
                             <?php } else {  ?>
                                <button class="btn btn-success" disabled>Selesai</button>     
                             <?php } ?>
                             
                             <!-- void hanya bisa ketika status masih proses dan void= 'tidak' -->
                             <?php if($l_invoice['status'] === 'Proses' && $l_invoice['void'] === 'tidak') { ?>
                                 <button class="btn btn-danger" data-toggle="modal" data-target="#voidModal<?= $l_invoice['id_trx']?>">Void</button>
                             <?php } ?>
                             
                        </td>
                    </tr>

                      <!-- modal selesai -->
                        <div class="modal fade" id="selesaiModal<?= $l_invoice['id_trx']?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Yakin #<?= $l_invoice['id_trx']?> sudah selesai?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                 <form action="" method="POST">
                                    <input type="hidden" name="id_trx" value="<?= $l_invoice['id_trx']?>">
                                    <button type="submit" name="btnselesaikan" class="btn btn-primary btn-block">Ya sudah!</button>
                                 </form>
                            </div>
                            </div>
                        </div>
                        </div>


                        <!-- modal void -->
                        <div class="modal fade" id="voidModal<?= $l_invoice['id_trx']?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Yakin #<?= $l_invoice['id_trx']?> divoid?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                 <form action="" method="POST">
                                    <input type="hidden" name="id_trx" value="<?= $l_invoice['id_trx']?>">
                                    <button type="submit" name="btnvoid" class="btn btn-danger btn-block">Void</button>
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>

                  <?php } ?>
                  </tbody>
               </table>
            </div>
        </div>
        <div class="col lg-6">

               <div class="row d-flex mb-3">
                  <div class="col-lg-6">
                     <div class="card card-body card-round">
                        <?php
                          $orderan =  mysqli_query($kon,"SELECT * FROM invoice WHERE resto='$_SESSION[resto]' AND tanggal='$now' ");
                        ?>
                          <h5><b><?= mysqli_num_rows($orderan); ?></b></h5>
                           <small>Total orderan hari ini</small> 
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="card card-body card-round">
                        <?php
                          $orderanproses =  mysqli_query($kon,"SELECT * FROM invoice WHERE resto='$_SESSION[resto]' AND tanggal='$now' AND status='Proses' ");
                        ?>
                           <h5><b><?= mysqli_num_rows($orderanproses); ?></b></h5>
                           <small>On proses</small> 
                     </div>
                  </div>
               </div>


               <div class="row d-flex mb-3">
                  <div class="col-lg-6">
                     <div class="card card-body card-round">
                     <?php
                        $total_total = 0;
                        $d_invoice = mysqli_query($kon,"SELECT total FROM invoice WHERE resto='$_SESSION[resto]' AND tanggal='$now' AND status='Selesai' ");
                        while($l_invoice = mysqli_fetch_array($d_invoice)) {
                        $total_total += $l_invoice['total'];
                        }
                        ?>
                          <h5><b>Rp. <?= number_format($total_total, 0, ',', '.')  ?></b></h5>
                           <small>Total (Income hari ini setelah kena diskon / kupon)</small> 
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="card card-body card-round">
                        <?php
                           $total_realtotal = 0;
                           $d_invoice = mysqli_query($kon,"SELECT realtotal FROM invoice WHERE resto='$_SESSION[resto]' AND tanggal='$now' AND status='Selesai' ");
                           while($l_invoice = mysqli_fetch_array($d_invoice)) {
                           $total_realtotal += $l_invoice['realtotal'];
                           }
                        ?>
                          <h5><b>Rp. <?= number_format($total_realtotal, 0, ',', '.')  ?></b></h5>
                           <small>Realtotal (Income hari ini jika tidak kena diskon / kupon) </small> 
                     </div>
                  </div>
               </div>

               <div class="row d-flex mb-3">
                    <div class="col-lg-12">
                      <div class="card card-body card-round">
                         <h5><b>Rp. <?= number_format($total_total -= $total_realtotal, 0, ',', '.')  ?></b></h5>
                         <small>Yang disubsidi untuk promo & kupon</small>
                      </div>
                     </div>
               </div>

               <div class="row d-flex">
                    <div class="col-lg-6">
                      <div class="card card-body card-round">
                        <?php
                         $d_void =  mysqli_query($kon,"SELECT * FROM invoice WHERE void='ya' AND resto='$_SESSION[resto]' AND tanggal='$now' ");
                        ?>
                         <h5><b><?= mysqli_num_rows($d_void); ?></b></h5>
                         <small>Total void</small>
                      </div>
                     </div>

                     <div class="col-lg-6">
                      <div class="card card-body card-round">
                        <?php
                            $tot_void = 0;
                            $d_void = mysqli_query($kon,"SELECT * FROM invoice WHERE void='ya' AND resto='$_SESSION[resto]' AND tanggal='$now' ");
                            while($l_void = mysqli_fetch_array($d_void)) {
                            $tot_void += $l_void['total'];
                            }
                        ?>
                         <h5><b><?= $tot_void ?></b></h5>
                         <small>
                           Total nominal void 
                           <br>
                           (Hanya menghitung berdasakan total bukan realtotal)
                        </small>
                      </div>
                     </div>
               </div>
    
    
    
    
            </div>
</div>




<?php require 'footer.php' ?>