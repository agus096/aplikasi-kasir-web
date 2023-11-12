<?php
session_start();

require 'koneksi.php';

#jika button di submit & tidak di submit 
if (isset($_POST['submit'])) {
    $cashier = $_SESSION['user'];
    $tanggal = date('Y-m-d');
    $realtotal = $_POST['realtotal'];
    $total = $_POST['total'];
    $bayar = $_POST['bayar'];
    $kembali = $_POST['kembali'];
    $nama = $_POST['nama'];
    $meja = $_POST['meja'];

    //bagian promo start
    $promo = $_POST['promo'];
    $jmlpotongan = trim($_POST['jmlpotongan']);
    //bagian promo end

    //bagian kupon start
    $kupon = $_POST['kupon'];
    $jmlpotongankupon = $_POST['jmlpotongankupon'];
    //bagian kupon end


    $id_trx = $_POST['id_trx'];
    $_SESSION['sudahdiprint'] = 'sudah';
} else {
    unset($_SESSION['keranjang_belanja']);
    header('location: /cart');
    die;
}

#jika sesion keranjang belanja kosong kembalikan ke index
if (empty($_SESSION['keranjang_belanja'])) {
    header('location: /cart');
    die;
}


#cek apakah idtrx sudah ada belum. jika sudah ada kembalikan ke halaman index
$l_trx = mysqli_query($kon, "SELECT * FROM invoice WHERE id_trx = '$id_trx' ");
if (mysqli_num_rows($l_trx) > 0 ) {
    unset($_SESSION['keranjang_belanja']);
} 

?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-3">

            <center>
                <h5 class="p-2 mb-3"> ==== <?= $_SESSION['resto']?> ====</h5>
            </center>

            <table class="mb-3">
                <tbody>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>&nbsp;&nbsp;<?= date('Y-m-d H:i:s') ?></td>
                    </tr>

                    <tr>
                        <td>No meja</td>
                        <td>:</td>
                        <td>&nbsp;&nbsp;
                            <?php 
                              if ($meja == null) {
                                echo " ";
                              } else {
                                echo $meja;
                              }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>&nbsp;&nbsp;<?= $nama ?></td>
                    </tr>

                    <tr>
                        <td>Cashier</td>
                        <td>:</td>
                        <td>&nbsp;&nbsp;<?=$_SESSION['user']?></td>
                    </tr>
                </tbody>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>nama</th>
                        <th>varian</th>
                        <th>Qty</th>
                        <th>harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>

                      <?php
                        $masukin_inv =  mysqli_query($kon,"INSERT INTO invoice values ('','$tanggal','$id_trx','$cashier','$nama','$meja','$realtotal','$jmlpotongan','$jmlpotongankupon','$total','$_SESSION[resto]','tidak','Proses')");
                      ?>

                    <!-- lopping isi sesion keranjang_belanja & Hitung sub total -->
                    <?php
                    foreach ($_SESSION["keranjang_belanja"] as $item) {
                        $sub_total = $item["jumlah"] * $item['harga'];

                        #insert array $sesion_keranjang_belanja ke db transaksi
                        #jika dalam perulangan array (foreach) syntax insert seperti biasa
                        $masukin_trx =  mysqli_query($kon,"INSERT INTO transaksi values ('','$tanggal', '$id_trx','$_SESSION[resto]','$item[nama_produk]','$item[kategori]','$item[varian]','$item[harga]','$item[jumlah]','$item[catatan]','$sub_total')");
                        if (!$masukin_trx) {
                            echo 'trans'. mysqli_error($kon)  ;
                        }

                        
                        
                        #update kupon yang sudah terpakai menjadi kadaluarsa
                        mysqli_query($kon,"UPDATE kupon set status ='nonaktif' WHERE kode='$kupon' ");
                    ?>
                        <tr>
                            <td><?php echo $item["nama_produk"]; ?></td>
                            <td>
                                <?php
                                $vari = explode('-', $item["varian"]);
                                echo $vari[1];
                                ?>
                            </td>
                            <td><?php echo $item["jumlah"]; ?></td>
                            <td><?php echo number_format($item['harga'], 0, ',', '.')  ?></td>

                            <script>
                                $("#jumlah<?php echo $no; ?>").bind('change', function() {
                                    var jumlah<?php echo $no; ?> = $("#jumlah<?php echo $no; ?>").val();
                                    $("#jumlaha<?php echo $no; ?>").val(jumlah<?php echo $no; ?>);
                                });
                                $("#jumlah<?php echo $no; ?>").keydown(function(event) {
                                    return false;
                                });
                            </script>

                            <td><?php echo number_format($sub_total, 0, ',', '.'); ?></td>

                        </tr>

                    <?php } ?>
                </tbody>
            </table>

            <table class="mb-3">
                <tbody>
                    <tr>
                        <td>Real total</td>
                        <td>:</td>
                        <td>&nbsp;&nbsp;<?= number_format($realtotal, 0, ',', '.') ?></td>
                    </tr>

                    <tr>
                        <td>Total</td>
                        <td>:</td>
                        <td>&nbsp;&nbsp;<?= number_format($total, 0, ',', '.') ?></td>
                    </tr>
                
                    <?php if(!empty($promo)) { ?>
                        <tr>
                            <td>Promo</td>
                            <td>:</td>
                            <td>&nbsp;&nbsp;<?= $promo ?></td>
                        </tr>
                
                        <tr>
                            <td>jml potongan</td>
                            <td>:</td>
                            <td>&nbsp; <?= number_format($jmlpotongan, 0, ',', '.') ?> </td>
                        </tr>
                    <?php } ?>

                    <?php if (!empty($kupon)) { ?>
                        <tr>
                            <td>kupon</td>
                            <td>:</td>
                            <td>&nbsp;&nbsp;<?= $kupon ?></td>
                        </tr>
                        <tr>
                            <td>jml potongan</td>
                            <td>:</td>
                            <td>&nbsp;<?= number_format($jmlpotongankupon, 0, ',', '.')  ?></td>
                        </tr>

                        <tr>
                            <td>Bayar</td>
                            <td>:</td>
                            <td>&nbsp;&nbsp;<?= number_format($bayar, 0, ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                    

                    <tr>
                        <td>Kembali</td>
                        <td>:</td>
                        <td>&nbsp;&nbsp;<?= number_format($kembali, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <center>==Terimakasih atas kunjungan anda==</center>

        </div>
    </div>




</div>

