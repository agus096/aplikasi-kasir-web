<?php
 session_start();
 error_reporting(0);

 require 'koneksi.php';
 require 'function.php';
 include 'header.php';
 include 'navbar.php';


 //pengeturan isi email
 if(isset($_POST['btnconfig'])) {
   $subject = pilter($kon,$_POST['subject']);
   $isiemail = pilter($kon,$_POST['isiemail']);

   #persiapan statement
   $stmt = mysqli_prepare($kon,"INSERT INTO template_email (resto,subject,isiemail) VALUES (?,?,?)" );

   #bind param
   mysqli_stmt_bind_param($stmt,"sss",$_SESSION['resto'],$subject,$isiemail);

   #ekseskusi statament 
   mysqli_stmt_execute($stmt);

 }

 
//pengaturan potongan  
if(isset($_POST['btncfgcut'])) {
    $potongan = pilter($kon,$_POST['potongan']);
    $tipe     = pilter($kon,$_POST['tipe']);

    #persiapkan statement 
    $stmt = mysqli_prepare($kon,"INSERT INTO set_potongan (resto,potongan,tipe) VALUES (?,?,?) ");

    #bind param 
    mysqli_stmt_bind_param($stmt,"sss",$_SESSION['resto'],$potongan,$tipe);

    #eksekusi statement 
    mysqli_stmt_execute($stmt);
 }
 
//pengaturan email pengirim
 if(isset($_POST['btnemailpengirim'])) {
    $emailpengirim = piltermail($kon,$_POST['emailpengirim']);
    $token = pilter($kon,$_POST['token']);

   #persiapkan statemnt 
   $stmt = mysqli_prepare($kon,"INSERT INTO set_email (resto,emailpengirim,token) VALUES (?,?,?) ");

   #bind param 
   mysqli_stmt_bind_param($stmt,"sss",$_SESSION['resto'],$emailpengirim,$token);

   #eksekusi statement 
   mysqli_stmt_execute($stmt);
 }


 //ubah data customer
 if (isset($_POST['btnubah'])) {
  $id  = pilter($kon,$_POST['id']);
  $nama = pilter($kon,$_POST['nama']);
  $wa = pilter($kon,$_POST['wa']);
  $email = piltermail($kon,$_POST['email']); 

  #persiapkan statemnt 
  $stmt = mysqli_prepare($kon,"UPDATE customer SET nama = ?, wa = ?, email = ?  WHERE id = ?  ");

  #bind param 
  mysqli_stmt_bind_param($stmt, "sssi", $nama, $wa, $email, $id);

  #eksekusi statement 
  mysqli_stmt_execute($stmt);

}


//hapus data customer
 if(isset($_POST['btnhapus'])) {
    $id = pilter($kon,$_POST['id']);

    #persiapkan statemt
    $stmt = mysqli_prepare($kon,"DELETE from customer WHERE id= ?");

    #bind param 
    mysqli_stmt_bind_param($stmt,'i',$id);

    #ekseskusi statement 
    mysqli_stmt_execute($stmt);
 }

?>

<!-- mengeluarkan data potongan -->
<?php
    $d_setpot =  mysqli_query($kon,"SELECT * FROM set_potongan WHERE resto = '$_SESSION[resto]' ");
    while($l_setpot = mysqli_fetch_array($d_setpot))  {
    #$lastData dibuat untuk menghasilkan array terakhir variable nya bisa apa saja yang pasti variable tersebut menyimpan data perulangan dari while
    $lastsetpot = $l_setpot;
    }
?>

<!-- mengeluarkan data setinggan isi email -->
<?php
    $d_config =  mysqli_query($kon,"SELECT * FROM template_email WHERE resto = '$_SESSION[resto]' ");
    while($l_config = mysqli_fetch_array($d_config))  {
    #$lastData dibuat untuk menghasilkan array terakhir variable nya bisa apa saja yang pasti variable tersebut menyimpan data perulangan dari while
    $lastData = $l_config;
    }
?>

<!-- mengeluarkan data setinggan email pengirim -->
<?php
    $d_setmail =  mysqli_query($kon,"SELECT * FROM set_email WHERE resto = '$_SESSION[resto]' ");
    while($l_setmail = mysqli_fetch_array($d_setmail))  {
    #$lastData dibuat untuk menghasilkan array terakhir variable nya bisa apa saja yang pasti variable tersebut menyimpan data perulangan dari while
    $lastsetmail = $l_setmail;
    }
?>

<?php 
    #buat random id (untuk id_invoice & id_trx)
      // Acak 8 digit text dan angka
      $random = "";
      for ($i = 0; $i < 10; $i++) {
          $randomChar = chr(rand(49, 122)); // acak karakter ASCII antara 49 (1) dan 122 (z)
          if (is_numeric($randomChar) || preg_match("/[a-z]/", $randomChar)) {
              $random .= $randomChar;
          } else {
              $i--;
          }
      }
  ?>

<div class="container-fluid">
 <div class="row">
   <div class="col-lg-7">
    <div class="card card-body card-round mt-3 mb-3">
      <div class="card card-body mt-3 mb-3" style="display: block;">
          <form action="kirim-kupon-masal" method="POST">
              <input type="hidden" name="kirim">
              Bagikan kupon ke semua customer via email 
          <button type="submit" class="btn btn-success float-right" style="margin-top: -8px;"><i class="fa-solid fa-paper-plane"></i> Kirim kupon masal</button>
          </form>
      </div>

       <table class="table" id="datatable">
          <thead class="thead-light">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Whatsapp</th>
              <th>Email</th>
              <th>Berikan kupon</th>
              <th>aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php  
              $no = 0;
              $d_cust =  mysqli_query($kon,"SELECT * FROM customer WHERE resto = '$_SESSION[resto]' ");
              while($l_cust = mysqli_fetch_array($d_cust)) {
              $no++;
            ?>
             <tr>
                <td><span class="badge badge-primary"><?=$no?></span></td>
                <td><?= $l_cust['nama'] ?></td>
                <td>
                    <?php 
                        if (empty($l_cust['wa'])) {
                          echo '';
                        } else { ?>
                            <a href=""><?= $l_cust['wa'] ?> <i class="fa fa-solid fa-up-right-from-square"></i></a>
                    <?php } ?>
                </td>
                <td>
                    <?php 
                        if (empty($l_cust['email'])) {
                          echo '';
                        } else { ?>
                            <a href=""><?= $l_cust['email'] ?> <i class="fa fa-solid fa-up-right-from-square"></i></a>
                    <?php } ?>
                </td>
                <td>
                    <form action="kirim-kupon-singel" method="POST">
                        <input type="hidden" name="emailpengirim" value="<?= $lastsetmail['emailpengirim'] ?>" class="form-control mb-3">
                        <input type="hidden" name="token" value="<?= $lastsetmail['token'] ?>" class="form-control-noregex mb-3">
                        <input type="hidden" name="subject" value="<?= $lastData['subject'] ?>" class="form-control mb-3">
                        <input type="hidden" name="isiemail" value="<?= $lastData['isiemail'] ?>" class="form-control mb-3">
                        <input type="hidden" name="potongan" value="<?=$lastsetpot['potongan']?>">
                        <input type="hidden" name="tipe" value="<?=$lastsetpot['tipe']?>">
                        <input type="hidden" name="email" value="<?= $l_cust['email'] ?>">
                        <button type="submit" name="btnsingelmail" class="btn btn-outline-success">Kirim kupon <i class="fa-solid fa-ticket"></i></button>
                    </form>
                </td>
                <td>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#modalubah<?= $l_cust['id'] ?>">Ubah</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#modalhapus<?= $l_cust['id'] ?>">Hapus</button>
                </td>
             </tr>

              <!-- Modal ubah -->
              <div class="modal fade" id="modalubah<?= $l_cust['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Ubah customer</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="POST">
                            <input type="hidden" class="form-control mb-3" name="id" value="<?= $l_cust['id'] ?>">
                         <label>Nama</label>
                            <input type="text" class="form-control mb-3" name="nama" value="<?= $l_cust['nama'] ?>">
                         <label>Whatsapp</label>
                            <input type="text" class="form-control mb-3" name="wa" value="<?= $l_cust['wa'] ?>">
                         <label>Email</label>
                            <input type="email" class="form-control-noregex mb-3" name="email" value="<?= $l_cust['email'] ?>">
                    </div>
                    <div class="modal-footer">
                       <button type="submit" class="btn btn-primary" name="btnubah">Ubah</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal hapus -->
              <div class="modal fade" id="modalhapus<?= $l_cust['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Yakin hapus?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="POST">
                        <input type="hidden" value="<?= $l_cust['id'] ?>" name="id">
                        <center><img src="https://i.ibb.co/Q62LnVw/garbage.png" width="25%"></center>
                        <button type="submit" name="btnhapus" class="btn btn-block btn-primary mt-3">Hapus!</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
             <?php  } ?>
          </tbody>
       </table> 
     </div>
   </div>


   <div class="col-lg-5">
    <div class="modal-header bg-primary text-white toppercart mt-3"><i class="fa-solid fa-gears"></i> Pengaturan jumlah potongan</div>
    <div class="card card-body mb-3" style="display: block; padding-bottom: 50px;">
     <div class="alert alert-warning">Semua kode kupon yang dikirim ke email customer akan menghasilkan portongan sesuai jumlah yang anda input.</div>
      <form action=" " method="POST">
        <label>Jumlah potongan</label>
        <input type="number" name="potongan" value="<?=$lastsetpot['potongan']?>" class="form-control mb-3">
        <label>Tipe</label>
        <select name="tipe" class="form-control selectize mb-3" readonly>
          <option value="<?=$lastsetpot['tipe']?>"><?=$lastsetpot['tipe']?></option>
          <option value="nominal">Nominal</option>
        </select>
        <button type="submit" name="btncfgcut" class="btn btn-primary float-right" >Simpan</button>
      </form>
    </div>

    <div class="modal-header bg-primary text-white toppercart"><i class="fa-solid fa-gears"></i> Pengaturan email pengirim</div>
    <div class="card card-body mb-3" style="display: block; padding-bottom: 50px;">
     <div class="alert alert-warning">Email pegirim wajib di setting terlebih dahulu via Google untuk bisa menggunakan fitur ini. <a href="">Pelajari</a>  </div>
      <form action="" method="POST">
        <label>Email pengirim</label>
          <input type="email" name="emailpengirim" value="<?= $lastsetmail['emailpengirim'] ?>" class="form-control-noregex mb-3">
        <label>Token</label>
          <input type="text" name="token" value="<?= $lastsetmail['token'] ?>" class="form-control mb-3">
        <button type="submit"  name="btnemailpengirim" class="btn btn-primary float-right">Simpan</button>
      </form>
    </div>

    <div class="modal-header bg-primary text-white toppercart"><i class="fa-solid fa-gears"></i> Pengaturan isi email</div>
    <div class="card card-body mb-3" style="display: block; padding-bottom: 50px;">
       <form action="" method="POST">
        <div class="form-group">
            <label>Subject email</label>
              <input type="text" name="subject" value="<?= $lastData['subject'] ?>" placeholder="Contoh: Diskon Rp 5000 untuk pembelian menu hotplate all varian" class="form-control mb-3">
            <div class="alert alert-warning">Tidak perlu menulis kode kupon didalam isi pesan karena sistem akan membuatkan otomatis kode nya & tiap orang akan menerima kode yang berbeda jadi tiap kode hanya 1x pakai. test saja dulu supaya anda paham.</div>
            <label>Isi emailnya..</label>
            <textarea class="form-control text-nowrap" name="isiemail" rows="3" placeholder="Hai pelanggan setia gunakan kupon ini untuk mendapatkan diskon sebesar Rp 5000 kupon hanya berlaku 1xpakai . cukup tunjukan email ini ke kasir saat pembayaran"><?= $lastData['isiemail'] ?></textarea> 
        </div>
         <button type="submit" name="btnconfig" class="btn btn-primary float-right mb-3">Simpan config email</button>
       </form>
         <button class="btn btn-success float-right mb-3 mr-3" data-toggle="modal" data-target="#modaltest"><i class="fa-solid fa-paper-plane"></i> Test kirim email</button>
    </div>
   </div>

   <!-- Modal -->
    <div class="modal fade" id="modaltest" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Masukan email tujuan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="kirim-test-email" method="POST">
                <input type="hidden" name="emailpengirim" value="<?= $lastsetmail['emailpengirim'] ?>" class="form-control mb-3">
                <input type="hidden" name="token" value="<?= $lastsetmail['token'] ?>" class="form-control mb-3">
                <input type="hidden" name="potongan" value="<?=$lastsetpot['potongan']?>">
                <input type="hidden" name="tipe" value="<?=$lastsetpot['tipe']?>">
                <input type="hidden" name="subject" value="<?= $lastData['subject'] ?>" >
                <input type="hidden" name="isiemail" value="<?= $lastData['isiemail'] ?>" >
                <label>Kode Kupon</label>
                <input type="text" name="kupon" value="<?= pilter($kon,$random) ?>" class="form-control  mb-3" readonly>
                <label>Email</label>
                <input type="text" name="email" value="..@gmail.com" class="form-control">
        </div>
        <div class="modal-footer">
            <button type="submit" name="btntestmail" class="btn btn-success">Kirim email test</button>
            </form>
        </div>
        </div>
    </div>
    </div>


    
</div>


<?php include 'footer.php'?>


<!-- singel email sweat alert! -->
<?php
  if (isset($_SESSION['kirimemail'])) {
    if ($_SESSION['kirimemail'] === 'terkirim') {
      echo '<script>swal("GOOD!", "Kupon terkirim via email!", "success");</script>';
    } elseif ($_SESSION['kirimemail'] === 'gagal') {
      echo '<script>swal("BAD!", "Kupon gagal terkirim via email!", "error");</script>';
    }

    unset($_SESSION['kirimemail']);
  }
?>