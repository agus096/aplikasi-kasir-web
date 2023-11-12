<?php 
  session_start();
  require 'koneksi.php';
  
  $kondisi =  $_SESSION['sortboard'];
  
?>


<?php 
  $list = mysqli_query($kon, "SELECT * FROM invoice WHERE status ='Proses' AND resto ='$_SESSION[resto]' ORDER BY id DESC " );
  While($data=mysqli_fetch_array($list)) {
?>

<div class="card mb-3" style="width: 25rem;">
  <div class="card-body write">
  <h5>Invoice# <?= $data['id_trx']?> <img src="https://i.ibb.co/YXwPYvY/pushpin-147918-640.png" alt="" style="float: right;" width="50px"></h5>
  
    <table class="table table-responsive">
        <thead>
            <tr>
                <td>nama produk</td>
                <td>kategori</td>
                <td>varian</td>
                <td>qty</td>
                <td>note</td>
            </tr>
        </thead>
        <tbody>
            <?php 
                $l_transaksi = mysqli_query($kon," SELECT * FROM transaksi where id_trx = '$data[id_trx]' $kondisi ");
                while($d_transaksi = mysqli_fetch_array($l_transaksi))  {
            ?>
            <tr>
                <td><?= $d_transaksi['nama'] ?></td>
                <td><?= $d_transaksi['kategori'] ?></td>
                <td><?php 
                      $vari = explode('-', $d_transaksi['varian']);

                      echo $vari[1];

                
                    ?>
                </td>
                <td><?= $d_transaksi['qty'] ?></td>
                <td><?= $d_transaksi['catatan'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table> 
   

  </div>
</div>

<?php } ?>

