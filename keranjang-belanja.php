<?php

if(empty($_SESSION['loginku'])) {
  header("Location: login");
}

require 'koneksi.php';


#jika button lanjut di tekan
if (isset($_POST['lanjut'])) {

    #hilangkan format rupiah di field uang untuk mendapatkan bentuk number
    $asli = array(
        'Rp. ',
        '.'
    );

    $diganti = array(
        '',
        ''
    );

    $mustpay = pilter($kon,$_POST['mustpay']);
    $uang = str_replace($asli, $diganti, $_POST['uang']);
    $wallet = pilter($kon,$_POST['wallet']);
    $wa =  pilter($kon,$_POST['wa']);
    $nama = pilter($kon,$_POST['nama']);
    $email = piltermail($kon,$_POST['email']);
    $meja = pilter($kon,$_POST['meja']);
    $kupon = pilter($kon,$_POST['kupon']);
    $lanjut = pilter($kon,'dibayar');



     #bandingkan mustpay & total uang yang di input
     if ($uang < $mustpay) {
          $_SESSION['moneytidakcukup'] = 'uang kurang';
          echo "<script>window.location.href = 'beranda';</script>";
          exit();
     } 
   

    // mengintip data customer
    $customer = mysqli_query($kon,"SELECT * FROM customer WHERE wa = '$wa' ");                               
    // menghitung jumlah customer
    $j_customer = mysqli_num_rows($customer);
    // jika belum pernah terinput masukan customer ke database (berdasarkan wa)
    if ($j_customer < 1){
    
        // Persiapan statement
        $stmt = mysqli_prepare($kon, "INSERT INTO customer (resto, nama, wa, email) VALUES (?, ?, ?, ?)");

        // Bind parameter
        mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['resto'], $nama, $wa, $email);

        // Eksekusi statement
        mysqli_stmt_execute($stmt);

    }

} else {
    $wa =  null;
    $uang = null;
    $nama = null;
    $email = null;
    $meja = null;
    $lanjut = null;
    $kupon = null;

}


#isset kodepromo
if (isset($_POST['kodepromo'])) {
    $kodepromo = pilter($kon,$_POST['kodepromo']);
#untuk simpan cecked
    $_SESSION['promo'] = $kodepromo;
} else {
    $kodepromo = null;
    $_SESSION['promo'] = null;
}


#tampilkan promo dari db promo
$l_promo = mysqli_query($kon, "SELECT * FROM promo WHERE namapromo = '$kodepromo' ");
$d_promo = mysqli_fetch_array($l_promo);

#tampilkan nominal kupon dari db kupon
$l_kupon = mysqli_query($kon, "SELECT * FROM kupon WHERE kode = '$kupon' AND status='aktif' ");
$d_kupon = mysqli_fetch_array($l_kupon);


if (isset($_POST['kode_produk']) && isset($_POST['jumlah']) && isset($_POST['varian'])) {
    $kode_produk = pilter($kon,$_POST['kode_produk']);
    $jumlah = pilter($kon,$_POST['jumlah']);

    #jika produk oneklik sesuaikan primary
    if (isset($_POST['oneklik'])) {
        $varian = pilter($kon,$_POST['kode_produk']) . "-" . null;
    } else {
        $varian = pilternostrip($kon,$_POST['varian']);
    }

    $sql = "select * from produk where kode_produk='$kode_produk'";
    $query = mysqli_query($kon, $sql);
    $data = mysqli_fetch_array($query);
    $kode_produk = $data['kode_produk'];
    $nama_produk = $data['nama'];
    $kategori = $data['kategori'];
    $harga = $data['harga'];
    $stok = $data['stok'];
} else {
    $kode_produk = "";
    $jumlah = 0;
}

if (isset($_POST['aksi'])) {
    $aksi = pilternostrip($kon,$_POST['aksi']);
} else {
    $aksi = "";
}

if (isset($_POST['catatan'])) {
    $catatan = pilter($kon,$_POST['catatan']);
} else {
    $catatan = "";
}


switch ($aksi) {
    case "tambah_produk":
        #buat varian sebagai primary
        $itemArray = array($varian => array('kode_produk' => $kode_produk, 'nama_produk' => $nama_produk, 'kategori' => $kategori, 'varian' => $varian, 'jumlah' => $jumlah, 'catatan' => ' ', 'harga' => $harga, 'stok' => $stok));
        if (!empty($_SESSION["keranjang_belanja"])) {
            if (in_array(pilternostrip($kon,$_POST['varian']), array_keys($_SESSION["keranjang_belanja"]))) {
                foreach ($_SESSION["keranjang_belanja"] as $k => $v) {
                    if (pilternostrip($kon,$_POST['varian']) == $k) {
                        $_SESSION["keranjang_belanja"] = array_merge($_SESSION["keranjang_belanja"], $itemArray);
                    }
                }
            } else {
                $_SESSION["keranjang_belanja"] = array_merge($_SESSION["keranjang_belanja"], $itemArray);
            }
        } else {
            $_SESSION["keranjang_belanja"] = $itemArray;
        }
        break;
        //Fungsi untuk menghapus item dalam cart
    case "hapus":

        if (!empty($_SESSION["keranjang_belanja"])) {
            foreach ($_SESSION["keranjang_belanja"] as $k => $v) {
                if ($_POST["varian"] == $k)
                    unset($_SESSION["keranjang_belanja"][$k]);
                if (empty($_SESSION["keranjang_belanja"]))
                    unset($_SESSION["keranjang_belanja"]);
            }
        }
        break;

    case "ubah":
        $itemArray = array($varian => array('kode_produk' => $kode_produk, 'nama_produk' => $nama_produk, 'kategori' => $kategori, 'varian' => $varian, 'jumlah' => $jumlah, 'catatan' => $catatan, 'harga' => $harga));
        if (!empty($_SESSION["keranjang_belanja"])) {
            foreach ($_SESSION["keranjang_belanja"] as $k => $v) {

                #jika varian == true
                if (pilternostrip($kon,$_POST["varian"]) == $k)
                    $_SESSION["keranjang_belanja"] = array_merge($_SESSION["keranjang_belanja"], $itemArray);
            }
        }
        break;
}

?>

<div class="bungkus-table" style="height: 691px; overflow:auto;">
    <table class="table table-striped">
        <tbody>
            <?php
                $no = 0;
                $sub_total = 0;
                $realtotal = 0;
                $total = 0;
                $total_berat = 0;
            ?>
            
            
            <?php if (empty($_SESSION["keranjang_belanja"])) { ?>
                
             <center>
                <div style="margin-top:19%"><img src="https://i.ibb.co/FWC8MG6/cashier.png" width="30%" alt="https://www.flaticon.com/free-icon/cashier_4472451?term=cashier&page=1&position=50&origin=search&related_id=4472451"></div>
                <span class="logocashier"><?= $_SESSION['resto']?></span>
                
                <h5 class="mt-5 text-secondary">
                    Detail transaksi akan muncul di bawah jika 
                    <br> 
                    cashier menginput produk & melanjutkan pembayaran
                </h5>
            </center>    

            <?php  } ?>
            



          <?php
            if (!empty($_SESSION["keranjang_belanja"])) :
                foreach ($_SESSION["keranjang_belanja"] as $item) :
                    $no++;
                    $sub_total = $item["jumlah"] * $item['harga'];

                    #realtotal adalah total yang seharusnya (jika tanpa promo)
                    $realtotal += $sub_total;

                    # $total adalah total - promo
                    if (empty($d_promo['potongan'])) {
                        $d_promo['potongan'] = null;
                        $d_promo['tipe'] = null;
                        $d_promo['namapromo'] = null;
                    }

                    if (empty($d_kupon['potongan'])) {
                        $d_kupon['potongan'] = null;
                        $d_kupon['kode'] = null;
                    }

                    #dengan promo
                    #jika tipe promo adalah nominal
                    if ( $d_promo['tipe'] == 'nominal') {
                        $total = $realtotal-$d_promo['potongan']-$d_kupon['potongan'];
                    } 
                     #jika tipe promo adalah persen
                    else if ($d_promo['tipe'] == 'percent') {

                        #hasilkan nominal dari pesen
                        $hasilpersen = $realtotal*$d_promo['potongan'] /100;

                        #batasi maksimal nominal dalam diskon persen
                        #jika kurang dari 20k
                        if ($hasilpersen < 20000) {
                            $hasilpersen = $realtotal*$d_promo['potongan'] /100;
                        
                        #jika lebih atau sama dengan 20k
                        } else if ($hasilpersen >= 20000) {
                            $hasilpersen = 20000;
                        }

                        #realtotal - nominal dari persen
                        $total = $realtotal-$hasilpersen-$d_kupon['potongan'];

                    #ketika tanpa promo
                    } else {
                        $total = $realtotal-$d_promo['potongan']-$d_kupon['potongan'];
                    }

                    
            ?>
                    <input type="hidden" name="kode_produk[]" class="kode_produk" value="<?php echo $item["kode_produk"]; ?>" />
                    <tr>
                        <td>
                            <div class="badge badge-primary"><?php echo $no; ?></div>
                        </td>
                        <td><?php echo $item["nama_produk"]; ?></td>
                        <td>
                            <?php
                            $vari = explode('-', $item["varian"]);

                            echo $vari[1];
                            ?>
                        </td>
                        <td>Rp. <?php echo number_format($item["harga"], 0, ',', '.'); ?> </td>
                        <td>
                            <input type="number" min="1" value="<?php echo $item["jumlah"]; ?>" class="form-control" style="width:100px" id="jumlah<?php echo $no; ?>" name="jumlah[]">
                            
                            
                            <script>
                                $("#jumlah<?php echo $no; ?>").bind('change', function() {
                                    var jumlah<?php echo $no; ?> = $("#jumlah<?php echo $no; ?>").val();
                                    $("#jumlaha<?php echo $no; ?>").val(jumlah<?php echo $no; ?>);
                                });
                                $("#jumlah<?php echo $no; ?>").keydown(function(event) {
                                    return true;
                                });
                            </script>

                        </td>

                        <td>
                            <textarea class="form-control" name="catatan" maxlength="30" id="catatan<?php echo $no; ?>"  style="height: 41px"> <?php echo $item["catatan"]; ?> </textarea>    
                        </td>

                        <script>
                                $("#catatan<?php echo $no; ?>").bind('change', function() {
                                    var catatan<?php echo $no; ?> = $("#catatan<?php echo $no; ?>").val();
                                    $("#catatann<?php echo $no; ?>").val(catatan<?php echo $no; ?>);
                                });
                                $("#catatan<?php echo $no; ?>").keydown(function(event) {
                                    return true;
                                });
                            </script>

                        <td>Rp. <?php echo number_format($sub_total, 0, ',', '.'); ?> </td>

                        <td>
                            <!-- form ubah-->
                            <form method="POST">
                                <input type="hidden" name="kode_produk" value="<?php echo $item["kode_produk"]; ?>" class="form-control">
                                <input type="hidden" name="aksi" value="ubah" class="form-control">
                                <input type="hidden" name="varian" value="<?php echo $item["varian"]; ?>" class="form-control">
                                <input type="hidden" name="halaman" value="keranjang-belanja" class="form-control">
                                <input type="hidden" name="jumlah" value="<?php echo $item["jumlah"]; ?>" id="jumlaha<?php echo $no; ?>" value="" class="form-control">
                                <input type="hidden" name="catatan" value="<?php echo $item["catatan"]; ?>" id="catatann<?php echo $no; ?>" value="" class="form-control">
                                <input type="submit" class="btn btn-outline-primary btn-xs" value="Ubah">
                                
                            </form>
                        </td>

                        <td>
                            <!-- form delete-->
                            <form method="POST">
                                <input type="hidden" name="varian" value="<?php echo $item["varian"]; ?>" class="form-control">
                                <input type="hidden" name="aksi" value="hapus" class="form-control">
                                <input type="submit" class="btn btn-outline-danger btn-xs" value="Delete">
                            </form>

                        </td>



                    </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
</div>

<!-- Modal bayar -->
<div class="modal fade" id="Modalbayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 25px;">
            <div class="modal-header">
                <h5><i class="fa-solid fa-cash-register"></i> Kasir <?=  $_SESSION['user'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa-regular fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">

                <!-- button lanjut -->
                <form action="" method="POST">
                    <center><h3>Transaksi Rp. <?php echo number_format($realtotal, 0, ',', '.'); ?></h3> </center>
                    <input type="hidden" name="mustpay" value="<?= $total ?>">
                    <label>Uang</label>
                    <div class="row">
                        <div class="col lg-6">
                            <input type="text" name="uang" maxlength="20" value="<?= $uang ?>" id="dengan-rupiah" autocomplete="off" placeholder="Wajib" class="form-control mb-3" required>
                        </div>
                        <div class="col lg-6">
                            <select name="wallet" value="<?= $wallet ?>" class="form-control selectize">
                                <option value="CASH">CASH</option>
                                <option value="BCA">BCA</option>
                                <option value="BRI">BRI</option>
                                <option value="BNI">BNI</option>
                                <option value="MANDIRI">MANDIRI</option>
                                <option value="MUAMALAT">MUAMALAT</option>
                                <option value="OVO">OVO</option>
                                <option value="DANA">DANA</option>
                                <option value="GOPAY">GOPAY</option>
                                <option value="GOFOOD">GOFOOD</option>
                                <option value="SHOPEEPAY">SHOPEEPAY</option>
                                <option value="SHOPEEFOOD">SHOPEEFOOD</option>
                            </select>
                        </div>
                    </div>   


                    <div class="alert alert-warning">
                        Nomor wa & email akan tersimpan otomatis jika dia adalah customer baru. <br>
                        Email optional! namun berguna untuk blast promo dengan fitur yang ada di aplikasi ini. <a href="#">Pelajari</a>
                    </div>


                    <di class="row">
                        <div class="col-lg-4">
                            <label>Whatsapp (Awali 62)</label>
                            <input type="number" value="<?= $wa ?>" name="wa" maxlength="14" id="wa" onkeyup="isi_otomatis()" autocomplete="off" placeholder="Optional" class="form-control mb-3">
                        </div>
                        <div class="col-lg-4">
                            <label>Nama</label>
                            <input type="text" value="<?= $nama ?>" name="nama" maxlength="10" id="nama" autocomplete="off" placeholder="Wajib" class="form-control mb-3">
                        </div>
                        <div class="col-lg-4">
                            <label>Email</label>
                            <input type="email" value="<?= $email ?>" name="email" maxlength="35" id="email" autocomplete="off" placeholder="Optional" class="form-control-noregex mb-3">
                        </div>
                    </di>

                    <label>No Meja </label>
                    <input type="text"  value="<?= $meja ?>" name="meja" maxlength="5" autocomplete="off" placeholder="Optional" class="form-control mb-3">
                    
                    
                    <?php 
                         $x_promo = mysqli_query($kon,"SELECT * FROM promo WHERE resto = '$_SESSION[resto]' ");

                         #cek apakah ada data promo milik resto ini?
                         #jika ada tampilkan label
                         if(mysqli_num_rows($x_promo) > 0 ) {
                            echo " <label style='display: block;'>Promo (Pilih dengan tepat!) <a href='#'>Pelajari</a></label>  ";
                         }

                         while($z_promo = mysqli_fetch_array($x_promo)) {
                         $namapromo =  $z_promo['namapromo'];
                         $deskripsi =  $z_promo['deskripsi'];
                    ?>
                     
                     <div class="boxed-check-group">
                        <label class="boxed-check">
                        <input class="boxed-check-input" value="<?= $namapromo ?>" type="radio" name="kodepromo"
                            <?php 
                                if($_SESSION['promo'] === $namapromo) {
                                    echo 'checked';
                                }
                            ?> >
                            <div class="boxed-check-label" style="text-align:center; border-radius: 25px;">
                                <h5><?= $namapromo ?></h5>
                                <span><?= $deskripsi ?></span>
                            </div>
                        </label>
                     </div>
                    
                    <?php
                    } 
                    ?>

                    <label>Kode voucher</label>  <span id="validasikupon"></span>
                    <input type="text" name="kupon" maxlength="15" id="datakupon" autocomplete="off" placeholder="Optional" class="form-control mb-3">
                </div>
            <div class="modal-footer">
                <!-- button lanjut -->
                <button type="submit" name="lanjut" value="dibayar" class="btn btn-primary">Bayar!</button>
                </form>
            </div>
        </div>
    </div>
</div>


