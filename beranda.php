<?php
session_start();


if(empty($_SESSION['loginku'])) {
  header("Location: login");
}

#hlilangkan semua sesion ketika refresh (add/edit item saat sudah print)
if (isset($_SESSION['sudahdiprint'])) {
   unset($_SESSION['keranjang_belanja']);
   unset($_SESSION['sudahdiprint']);
}
?>

<?php
$namaresto = $_SESSION['resto'];
?>

<?php 
    include 'header.php';
    include 'navbar.php';
?>


<body class="bg-light">

  <div class="container-fluid mt-3">
    <div class="row">
      <div class="col-lg-6">
      <input type="text" name="keyword" maxlength="11" placeholder="&#xF002; Cari produk" autofocus id="keyword" class="form-control mb-3 searchstyle">

      
        
        <!-- all produk -->
        <form action="" method="POST" style="display: inline;">
          <button name="sort"  class="btn btn-primary mb-3" value="all" onchange="this.form.submit();" style="width:100px;"><i class="fa fa-solid fa-list"></i> All</button>
        </form>

        <!-- recomended -->
        <form action="" method="POST" style="display: inline;">
          <button name="sort" class="btn btn-primary  mb-3" value="recomended" onchange="this.form.submit();" style="width:100px;"><i class="fa fa-solid fa-star"></i>Recom</button>
        </form>

        <!-- makanan -->
        <form action="" method="POST" style="display: inline;">
          <button name="sort" class="btn btn-primary  mb-3" value="makanan" onchange="this.form.submit();" style="width:100px;"><i class="fa fa-solid fa-pizza-slice"></i> Food</button>
        </form>

         <!-- minuman -->
         <form action="" method="POST" style="display: inline;">
          <button name="sort" class="btn btn-primary  mb-3" value="minuman" onchange="this.form.submit();" style="width:100px;"><i class="fa fa-solid fa-mug-hot"></i> Drink</button>
        </form>
      

          <div id="hasilcari">
              <?php include "produk.php"; ?>
          </div>
       

            
        
      </div>
      <div class="col-lg-6">
        <div class="modal-header bg-primary text-white toppercart">Keranjang</div>
        <?php include "keranjang-belanja.php"; ?>
      </div>
    </div>


    <div class="row bg-light">
      <div class="col-lg-6 P-3">
        <div class="row">
          <div class="col-lg-6">
          <?php if (!empty($_SESSION["keranjang_belanja"]) && !empty($_POST['uang'])) { ?>
          <div class="modal-header bg-primary text-white toppercart">Detail invoice</div>
            <table class="table card card-body h5">
              <tbody>
                  <tr>
                    <td>Total</td>
                    <td>:</td>
                    <td><?php echo number_format($total, 0, ',', '.')." Via ".$wallet;    ?></td>
                  </tr>


                  <!-- jika menggunakan promo  (alias potongan tidak null)-->
                  <?php if ($d_promo['potongan'] != null) {  ?>  
                  <tr>
                    <td>Desc Promo</td>
                    <td>:</td>
                    <td>
                      <?php
                        echo $d_promo['deskripsi'];
                      ?>
                    </td>
                  </tr>

                  <tr>
                    <td>Jml Potongan</td>
                    <td>:</td>
                    <td>
                      <?php
                          #jika tipe promo adalah nominal
                          if ($d_promo['tipe'] == 'nominal') {
                                 echo number_format($d_promo['potongan'], 0, ',', '.');
                          }
                          
                          #jika tipe promo adalah persen
                          else if ($d_promo['tipe'] == 'percent') {
                                echo number_format($hasilpersen, 0, ',', '.');
                        } 
                      ?>
                    </td>
                  </tr>
                  <?php } ?>

                  <!-- jika menggunakan kupon  (alias kupon tidak null)-->
                  <?php if ($d_kupon['potongan'] != null) {  ?>  
                    <tr>
                      <td>Kode kupon</td>
                      <td>:</td>
                      <td>
                        <?php
                          echo $d_kupon['kode'];
                        ?>
                      </td>
                    </tr>

                    <tr>
                      <td>Jml potongan</td>
                      <td>:</td>
                      <td>
                        <?php
                          echo number_format($d_kupon['potongan'], 0, ',', '.')
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                  

                 

                  <tr>
                    <td>Bayar</td>
                    <td>:</td>
                    <td><?= number_format($uang, 0, ',', '.');  ?></td>
                  </tr>
                  <tr>
                    <td>Kembali</td>
                    <td>:</td>
                    <?php $kembali = $uang - $total; ?>
                    <td><?= number_format($kembali, 0, ',', '.') ?> </td>
                  </tr>

                  <!-- lempar hasil hitung2an ke hal.
                  <script language="javascript">
                    window.open(" 
                    .php?total=<?= $total ?>&bayar=<?= $uang ?>&kembali=<?= $kembali ?>&nonama=<?= $nonama ?> ", "_blank");
                  </script>
                  -->

                <?php  }  ?>
              </tbody>
            </table>
          </div>

          <div class="col-lg-6">
          <?php if (!empty($_SESSION["keranjang_belanja"])) { ?>
           <div class="modal-header bg-primary text-white toppercart">Detail invoice</div>
            <table class="table card card-body h5">
              <tbody>
                <tr>
                  <td>Real Total</td>
                  <td>:</td>
                  <td><?php echo number_format($realtotal, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td><?php echo $nama." ". $wa ?></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td><?php echo $email ?></td>
                </tr>
                <?php if (!empty($meja)) { ?>
                <tr>
                  <td>No meja</td>
                  <td>:</td>
                  <td><?php echo $meja ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
          </div>

        </div>

      </div>

      <div class="col-lg-6">
        <div class="mt-3">

        <div id="kondisi">

        <?php if (!empty($_SESSION["keranjang_belanja"])) { ?>
          <!-- Button bayar modal trigger -->
          <button type="button" class="btn btn-primary btn-lg ml-2" style="width: 32%;" data-toggle="modal" data-target="#Modalbayar">
          <i class="fa-solid fa-money-bill-wave"></i> 
          <?php
              if ($lanjut == 'dibayar') {
                echo 'Ubah';
              } else {
                echo 'Bayar';
              }
            ?>
          </button>

          <a href="clear-cart.php" class="btn btn-primary btn-lg ml-1" style="width: 32%;"><i class="fa-solid fa-repeat"></i> Transaksi baru</a>

          <?php if ($lanjut == 'dibayar') { ?>

            <?php 
              #buat random id (untuk id_invoice & id_trx)
               // Acak 8 digit text dan angka
                $random = "";
                for ($i = 0; $i < 8; $i++) {
                    $randomChar = chr(rand(49, 122)); // acak karakter ASCII antara 49 (1) dan 122 (z)
                    if (is_numeric($randomChar) || preg_match("/[a-z]/", $randomChar)) {
                        $random .= $randomChar;
                    } else {
                        $i--;
                    }
                }
            ?>
          
            <form action="print" method="POST" style="display:inline;" class="ml-1">
              <input type="hidden" name="realtotal" value="<?= $realtotal ?>">
              <input type="hidden" name="total" value="<?= $total ?>">

              <!-- Bagian promo start -->
              <input type="hidden" name="promo" value="<?= $d_promo['namapromo'] ?>">
              <input type="hidden" name="jmlpotongan" value="
                  <?php
                      #jika tipe promo adalah nominal
                      if ($d_promo['tipe'] == 'nominal') {
                              echo $d_promo['potongan'];
                      }
                      
                      #jika tipe promo adalah persen
                      else if ($d_promo['tipe'] == 'percent') {
                            echo $hasilpersen;
                    } 
                  ?>
              ">
              <!-- Bagian promo end --> 

              <!-- bagian kupon start -->
              <input type="hidden" name="kupon" value="<?= $d_kupon['kode'] ?>">
              <input type="hidden" name="jmlpotongankupon" value="<?= $d_kupon['potongan'] ?>">
              <!-- bagian kupon end -->

              <input type="hidden" name="bayar" value="<?= $uang ?>">
              <input type="hidden" name="kembali" value="<?= $kembali ?>">
              <input type="hidden" name="nama" value="<?= $nama ?>">
              <input type="hidden" name="meja" value="<?= $meja ?>">
              <input type="hidden" name="id_trx" value="<?= $random ?>">

              
              <div style="display: contents;">
                <button type="submit" id="buttonku" name="submit" formtarget="_blank" class="btn btn-primary btn-lg " style="width: 32%;">
                  <i class="fa-solid fa-print"></i> Print & simpan
                </button>
              </div> 

            </div>
             
            </form>

            <div class="card card-body mt-2">
              <span>⚠️ Tombol "Transaksi baru" bisa berarti <b>membatalkan</b> orderan jika orderan belum di print!</span>
            </div>
          
          
          <?php } ?>

        <?php  }  ?>
      </div>
    </div>

    </div>


  </div>
</body>

</div>



<?php include 'footer.php' ?>

<?php if(isset($_SESSION['noinv'])) { ?>
   
   <script>swal("GOOD!", "Transaksi sebelumnya tersimpan & siap membuat transaksi selanjutnya!", "success");</script>
 
   <?php unset($_SESSION['noinv'])  ?>
 
 <?php } ?>

 <?php if(isset($_SESSION['moneytidakcukup'])) { ?>
   
   <script>swal("BAD!", "Uang yang di input tidak cukup!", "error");</script>
 
   <?php unset($_SESSION['moneytidakcukup'])  ?>
 
 <?php } ?>






