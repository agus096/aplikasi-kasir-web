<?php
session_start();
require 'koneksi.php';
require 'function.php';
include 'header.php';
include 'navbar.php';

#tambah
if(isset($_POST['submit'])) {
    $resto = pilter($kon,$_POST['resto']);
    $namapromo = pilter($kon,$_POST['namapromo']);
    $tipe = pilter($kon,$_POST['tipe']);
    $potongan = pilter($kon,$_POST['potongan']);
    $deskripsi = pilter($kon,$_POST['deskripsi']);

    #persiapan statement
    $stmt = mysqli_prepare($kon, "INSERT INTO promo (namapromo,resto,tipe,deskripsi,potongan) VALUES (?,?,?,?,?)  ");
    
    #Bind parameter 
    mysqli_stmt_bind_param($stmt,"sssss",$namapromo,$resto,$tipe,$deskripsi,$potongan);

    #eksekusi statement 
    mysqli_stmt_execute($stmt);

}

#hapus
if (isset($_POST['subdelete'])) {
    $idpromo = pilter($kon,$_POST['id']);
    mysqli_query($kon, "DELETE FROM promo WHERE id = '$idpromo' ");
}


?>

<div class="container-fluid">
    <div class="row">
        <div class="col lg-6">
            <div class="card card-body card-round mt-3 mb-3">
                <form action="" method="POST">
                    <input type="hidden" name="resto" value="<?= $_SESSION['resto'] ?>" class="form-control mb-3">

                    <label>Nama Promo</label>
                    <input type="text" name="namapromo" maxlength="15" class="form-control mb-3">

                    <div class="alert alert-warning">
                        Khusus potongan percent jumlah potongan tidak akan lebih dari 20.000.
                        <br> 
                        Misal total transaksi 1.000.000 anda berikan diskon 5percent . total potongan tidak akan menjadi 50.000 tapi hanya 20.000
                    </div>

                    <label>Percent / nominal</label>
                    <select name="tipe" class="selectize mb-3">
                        <option value="percent">Percent (Max potongan yg diberikan Rp 20.000)</option>
                        <option value="nominal">Nominal</option>
                    </select>

                    <div class="alert alert-warning">
                        Jika membuat diskon berupa persen masukan angka misal (5)
                        <br> 
                        Jika membuat diskon berupa nominal masukan angka berbentuk harga misal (10000)
                    </div>

                    <label>Potongan</label>
                    <input type="number" name="potongan" maxlength="19" class="form-control mb-3">

                    <label>Deskripsi</label>
                    <textarea class="form-control mb-3" name="deskripsi" maxlength="50" placeholder="Contoh : Potongan transaksi 5percent untuk pembelian indomie rebus semua varian" rows="3"></textarea>

                    <button type="submit" name="submit" class="btn btn-primary">Tambah!</button>
                    
                </form>
            </div>
        </div>

        <div class="col lg-6">
           <div class="row">
             <div class="col lg-6">
                <div class="card card-body card-round mt-3">
                    <?php
                    $d_customer =  mysqli_query($kon,"SELECT * FROM customer WHERE resto = '$_SESSION[resto]' ");
                    $jml_customer = mysqli_num_rows($d_customer);
                    ?>
                    <span><?= $jml_customer ?></span>
                    <small>Total customer anda</small>
                    <i class="icondetail fa-solid fa-user fa-2x"></i>
                </div>
             </div>

             <div class="col lg-6">
              <div class="card card-body card-round mt-3">
                <!-- mengeluarkan data setinggan email pengirim -->
                <?php
                    $d_setmail =  mysqli_query($kon,"SELECT * FROM set_email WHERE resto = '$_SESSION[resto]' ");
                    while($l_setmail = mysqli_fetch_array($d_setmail))  {
                    #$lastData dibuat untuk menghasilkan array terakhir variable nya bisa apa saja yang pasti variable tersebut menyimpan data perulangan dari while
                    $lastsetmail = $l_setmail;
                    }
                ?>
               <span>
                      <?php
                           if(empty($lastsetmail['emailpengirim'])) {
                             echo 'Email pengirim belum di atur';
                           } else {
                              echo $lastsetmail['emailpengirim'];
                           }
                      ?>
               </span>
               <small>Email pengirim</small>
               <i class="icondetail fa-solid fa-envelope fa-2x"></i>
               </div>
             </div>
           </div>

            <div class="alert alert-success mt-3">Untuk bisa menggunakan fitur blast via email anda perlu <b>mengatur email pengirim</b> di menu <a href="customer">customer</a> </div>
            <table class="table mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Nama promo</th>
                        <th>Potongan</th>
                        <th>Tipe</th>
                        <th>Deskripsi</th>
                        <th>Hapus</th>
                        <th>Blast</th>
                    </tr>
                </thead>
                <tbody class="table-striped">
                  <?php $d_promo = mysqli_query($kon,"SELECT * FROM promo WHERE resto = '$_SESSION[resto]' ");
                        while($l_promo = mysqli_fetch_array($d_promo)) {
                   ?>

                    <tr>
                        <td><?= $l_promo['namapromo']?></td>
                        <td><?= $l_promo['potongan']?></td>
                        <td><?= $l_promo['tipe']?></td>
                        <td><?= $l_promo['deskripsi']?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="id" value="<?= $l_promo['id']?>">
                                <button type="sumbit" name="subdelete" class="btn btn-danger">Hapus</button>  
                            </form>
                        </td>
                        <td>   
                            <!-- blast belum di tangani -->
                            <?php
                                if(empty($lastsetmail['emailpengirim']) OR $jml_customer === 0 ) {
                                    echo "<button type='button' name='subdelete' class='btn btn-success disabled'>Blast</button>";
                                } else {
                                    echo "<button type='submit' name='subdelete' class='btn btn-success'>Blast</button>";
                                }
                            ?>
                        </td>
                    </tr>
                  <?php } ?>
                </tbody>
            </table>
        </div>
   </div>
</div>

<?php include 'footer.php'; ?>