<?php

session_start();

require 'koneksi.php';
require 'function.php';

#jika button di submit 

if(isset($_POST['submit'])) {  
    
    $nama      = pilter($kon, $_POST['nama']);
    $kategori  = pilter($kon,$_POST['kategori']);
    $keterangan = pilter($kon,$_POST['keterangan']);
    $varian    = pilterarray($kon,$_POST['varian']) ;
    $harga     = pilter($kon,$_POST['harga']);
    $recomended = pilter($kon,$_POST['recomended']);

    
    #sesi menangani URL sebagai kunci dilakan Query atau tidak
    $url       = pilterurl($kon,filter_var($_POST['urlgambar'], FILTER_VALIDATE_URL)) ;

    if ($url) {
        #memcah url ke array 
        $parsed_url = parse_url($url);
        #$hostname berisi item yang bersumber dari array dengan index host
        $hostname = $parsed_url['host'];
    } else {
        $hostname = null;
    }

    #mencocokan apakah url yang di input sesuai dengan $hostname yang tidak lain adalah isi array dengan index host
    if (preg_match("/ibb\.co$/", $hostname)) {
    #JIKA URL NYA DARI IMBB lakukan Query
    
    

    // Acak 8 digit text dan angka
    $randomString = "";
    for ($i = 0; $i < 8; $i++) {
        $randomChar = chr(rand(49, 122)); // acak karakter ASCII antara 49 (1) dan 122 (z)
        if (is_numeric($randomChar) || preg_match("/[a-z]/", $randomChar)) {
            $randomString .= $randomChar;
        } else {
            $i--;
        }
    }
 

    $query = "";

    if (empty($varian)) {
        $query .= "INSERT INTO produk (kode_produk,resto,nama,stok,harga,keterangan,kategori,recomended,gambar) VALUES ('$randomString','$_SESSION[resto]','$nama','ada','$harga','$keterangan','$kategori','$recomended','$url') ;";
    } else {
        $query .= "INSERT INTO produk (kode_produk,resto,nama,stok,harga,keterangan,kategori,recomended,gambar) VALUES ('$randomString','$_SESSION[resto]','$nama','ada','$harga','$keterangan','$kategori','$recomended','$url') ;";
        
        foreach($varian as $varians) {
            #diberikan pengecekan kondisi supaya sistem tetap menginput data ketika varian kosong
            if (!empty($varians)) {
            $query .= "INSERT INTO varian (nama_produk,resto,varian) VALUES ('$nama','$_SESSION[resto]','$varians') ;";
           }
        }
    }

    if (mysqli_multi_query($kon, $query)) {
    $_SESSION['produkditambah'] = 'berhasil';
    } else {
        // tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . mysqli_error($kon);
    }

 
    } else {
        $_SESSION['produkditambah'] = 'gagal';
    }



    } else {
        $nama = $urlgambar = $kategori = $recomended = $keterangan = $varian = $harga = null;
    }
  

    include 'header.php';
    include 'navbar.php';

?>

<div class="container mt-3">

 <div class="alert alert-success">Untuk mengedit produk yang ada. anda cukup arahkan cursor ke gambar produk pada halaman kasir</div>

 <div class="card card-body card-round">
    <form action="" method="POST">

        <label>Nama produk</label>
        <input type="text" name="nama" maxlength="20" class="form-control mb-2" required>

        <label>Kategori</label>
        <select name="kategori" class="form-control selectize mb-3" required>
            <option value="makanan">Makanan</option>
            <option value="minuman">Minuman</option>
        </select>

        <label>Keterangan</label>
        <input type="text" name="keterangan" maxlength="45" class="form-control mb-3">
        
        <label>Url gambar (Hanya menerima url <a href="https://imgbb.com/" target="_blank">imgbb.com</a> ) <a href="#">Pelajari cara mengupload gambar dengan url</a> </label>
        <input type="text" name="urlgambar" id="inputurl" class="form-control-noregex mb-3" autocomplete="off" placeholder="contoh : https://i.ibb.co/Wg1F0Bp/nasi-goreng.jpg" required> 

        <!-- menampilkan gambar dari url dengan ajax -->
        <div id="tampilgambar" class="mb-3"></div>

        <div class="alert alert-warning">
            Hanya bisa membuat varian dengan harga yang sama, jika ingin membuat varian dengan harga yang berbeda silahkan buat produk baru 
            Contoh : Teh manis varian nya Hot / ice
        </div>

        <label>Varian</label>
        <input type="text" name="varian[]" maxlength="35" class="form-control mb-3">

        <label>Varian</label>
        <input type="text" name="varian[]" maxlength="35" class="form-control mb-3">

        <label>Varian</label>
        <input type="text" name="varian[]" maxlength="35" class="form-control mb-3">

        <label>Varian</label>
        <input type="text" name="varian[]" maxlength="35" class="form-control mb-3">


        <label>Harga</label>
        <input type="number" name="harga" maxlength="10" class="form-control mb-3" required>

        <label>Recomended?</label>
        <select name="recomended" class="form-control selectize mb-3" required>
            <option value=" ">Tidak</option>
            <option value="recomended">Ya</option>
        </select>

        <button type="sumbit" name="submit" class="btn btn-primary">Tambah!</button>


    </form>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
  //matikan klik kanan
  window.oncontextmenu = function() {
    return false;
  } 
</script>

<?php
  if (isset($_SESSION['produkditambah'])) {
    if ($_SESSION['produkditambah'] === 'berhasil') {
      echo '<script>swal("GOOD!", "Produk berhasil di tambah!", "success");</script>';
    } elseif ($_SESSION['produkditambah'] === 'gagal') {
      echo '<script>swal("BAD!", "Produk gagal di tambah!", "error");</script>';
    }

    unset($_SESSION['produkditambah']);
  }
?>