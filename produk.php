<div class="row" style="height: 691px; overflow:auto;">
    <?php   
        include 'koneksi.php';
        require 'function.php';

        if(isset($_POST['submit'])) {  
    
        $id        = pilter($kon, $_POST['id_produk']);
        $nama      = pilter($kon, $_POST['nama']);
        $harga     = pilter($kon,$_POST['harga']);
        $recomended = pilter($kon,$_POST['recomended']);
        $stok       = pilter($kon,$_POST['stok']);
    
        
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
            
         $ubah = mysqli_query($kon,"UPDATE produk SET nama = '$nama',stok = '$stok', harga = '$harga',recomended = '$recomended',gambar = '$url' WHERE id_produk= '$id' ");

         if (!$ubah) {
            echo mysqli_error($kon);
         }
      } else {
        echo "<script>alert('Url gambar Tidak berasal dari imgbb!')</script>";
      }
    }  
        

    #error_reporting(0);

    #jika form sort tidak di submit semua null
    if (!isset($_POST['sort'])) {
        $_POST['sort'] = null;
        $kond = null;
    }

    #tangkap hasil short
    if(pilter($kon,$_POST['sort']) == 'recomended') {
        $kond = " where recomended ='recomended'  ";
    } else if(pilter($kon,$_POST['sort']) == 'all')  {
        $kond = null;
    } else if(pilter($kon,$_POST['sort']) == 'makanan') {
        $kond = " where kategori ='makanan'  ";
    }else if(pilter($kon,$_POST['sort']) == 'minuman') {
        $kond = " where kategori ='minuman'  ";
    }

    #ambil keyword untuk pencarian
    #jika form di ketik dan di masukan value
    if (isset($_GET['keyword'])) {
        #tidak bisa berjalan jika tidak membuat sesion_start disini.
        session_start();
        $namaresto = $_SESSION['resto'];
        $sql = "select * from produk WHERE nama LIKE '%" . pilter($kon,$_GET['keyword'])  . "%' AND resto = '$namaresto'  order by id_produk desc";

        #tapi jika keyword ='' kosong .tampilkan semua
      if (pilter($kon,$_GET['keyword']) == '') {
        $sql = "select * from produk WHERE resto = '$namaresto'  order by id_produk desc";
    } 
    
    } else {
        if ($kond == null) {
            $kond2 = 'WHERE';
        }else {
            $kond2 = 'AND';
        }
        $sql = "select * from produk $kond $kond2 resto = '$namaresto'   order by id_produk desc";
    }  

        
    #tapi jika tidak ada upaya input keyword tampilkan semua
    $sql;
    $hasil = mysqli_query($kon, $sql);
    $jumlah = mysqli_num_rows($hasil);
    if ($jumlah > 0) {
        while ($data = mysqli_fetch_array($hasil)) :
            //cek apakah ada varian dalam sebuah produk
            $varian = mysqli_query($kon, "SELECT * FROM varian WHERE nama_produk = '$data[nama]' ");
            $d_varian = mysqli_num_rows($varian);
    ?>

    <?php
       if($data['stok'] === 'ada') {
          $kondisibtn = '';
          $warnabtn = 'primary';
       }else {
         $kondisibtn = 'disabled';
         $warnabtn = 'secondary';
       }
    ?>


            <div class="col-sm-3" style="margin-top:20px">
                <div class="card" style="border-radius: 25px;">
                    <div class="thumbnail" style="padding:10px;">

                        <div class="img-container">
                            <a href="#"><img src="<?php echo $data['gambar']; ?>" width="100%" height="140" style="border-radius:25px;"></a>
                            <div class="text-overlay text-warning">
                                <a href="#" data-toggle="modal" data-target="#modal-<?= $data['id_produk'] ?>"><span class="fa fa-solid fa-pen-to-square text-white" style="font-size:15px"> Ubah</span></a>
                                 <br>
                                 <br>
                                <a href="#" data-toggle="modal" data-target="#modaldetail-<?= $data['id_produk'] ?>"><span class="fa fa-solid fa-eye text-white" style="font-size:15px"> Detail</span></a>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modal-<?= $data['id_produk'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="border-radius: 25px;">
                            <div class="modal-header">
                                <h5 class="modal-title">Ubah data Produk</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               
                            <form action="" method="POST">

                                <input type="hidden" name="id_produk" value="<?= $data['id_produk'] ?>" maxlength="10" class="form-control mb-3">

                                <label>Nama produk</label>
                                <input type="text" name="nama" value="<?= $data['nama'] ?>" maxlength="20" class="form-control mb-2">
                                
                                <label>Url gambar (Hanya menerima url <a href="https://imgbb.com/" target="_blank">imgbb.com</a> ) <a href="#">Pelajari cara mengupload gambar dengan url</a> </label>
                                <input type="text" name="urlgambar" value="<?= $data['gambar'] ?>" class="form-control mb-3" autocomplete="off" placeholder="contoh : https://i.ibb.co/Wg1F0Bp/Star-images-9454.png"> 

                                <label>Harga</label>
                                <input type="number" name="harga" value="<?= $data['harga'] ?>" maxlength="10" class="form-control mb-3">

                                <label>Recomended?</label>
                                <select name="recomended" class="form-control selectize mb-3">
                                    <option value="<?= $data['recomended'] ?>"><?= $data['recomended'] ?></option>
                                    <option value="tidak">tidak</option>
                                    <option value="recomended">Ya</option>
                                </select>

                                <label>Produk masih ada?</label>
                                <select name="stok" class="form-control selectize mb-3">
                                    <option value="<?= $data['stok'] ?>"><?= $data['stok'] ?></option>
                                    <option value="ada">ada</option>
                                    <option value="habis">habis</option>
                                </select>

                                <button type="sumbit" name="submit" class="btn btn-primary float-right">ubah</button>
                            </form>
 
                            </div>
                            </div>
                        </div>
                        </div>

                        <!-- Modaldetail -->
                        <div class="modal fade" id="modaldetail-<?= $data['id_produk'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="border-radius: 25px;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detail <?= $data['nama'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php
                                   if (empty($data['keterangan'])) {
                                    echo 'Tidak ada keterangan apapun tentang produk ini..';
                                   } else {
                                    echo $data['keterangan'];
                                   }
                                ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                        </div>

                        <?php if ($data['recomended'] == 'recomended') { ?>
                            <img src="https://i.ibb.co/BgtGW0s/star-images-9454.png" width="25" class="float-right" style="position: absolute; right: 8; top:2;">
                        <?php }?>

                        <div class="caption">
                            <center>
                                <div style="height: 70px;">
                                    <b style="font-size:18px;" class="p-2"><?php echo $data['nama']; ?></b>
                                </div>
                                <h5 class="mb-3">Rp. <?php echo number_format($data['harga'], 2, ',', '.'); ?></h5>

                                <?php

                                if ($d_varian <= 0) {  ?>

                                
                                <form action='' method='POST'>

                                <!-- hidden input-->
                                <input type='text' value='<?=$data['kode_produk']?>' name='kode_produk' hidden>
                                <input type='text' value='tambah_produk' name='aksi' hidden>
                                <input type='text' value='1' name='jumlah' hidden>
                                <input type='hidden' value='' name='varian' >
                                <input type='text' value='oneklik' name='oneklik' hidden>
                                <!-- hidden input-->
                            
                                <button class='btn btn-<?= $warnabtn ?>' type='submit' style="border-radius:25px;" <?= $kondisibtn ?>>Tambahkan</button>
                                </form>
                                     
                            
                                <?php } else { ?>

                                    <button type="button" class="btn btn-<?= $warnabtn ?>" style="border-radius:25px;" data-toggle="modal" data-target="#exampleModal<?=$data['kode_produk']?>" <?= $kondisibtn ?>>
                                      Pilih varian/toping
                                    </button>
                                 
                                <?php  } ?>
                                


                            </center>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal<?= $data['kode_produk'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Pilih varian / topping</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST">

                                            <!-- hidden input-->
                                            <input type="text" value="<?= $data['kode_produk'] ?>" name="kode_produk" hidden>
                                            <input type="text" value="tambah_produk" name="aksi" hidden>
                                            <input type="text" value="1" name="jumlah" hidden>
                                            <!-- hidden input-->

                                            <select name="varian" class="form-control selectize mb-3" style="width: 100%; height: 40px; border-radius: 8px;">
                                                <?php
                                                $varianModal = mysqli_query($kon, "SELECT * FROM varian WHERE nama_produk = '$data[nama]' AND resto = '$namaresto' ");
                                                while ($d_varianModal = mysqli_fetch_array($varianModal)) {
                                                ?>
                                                    <option value="<?= $data['kode_produk'] ?>-<?= $d_varianModal['varian'] ?>"><?= $d_varianModal['varian'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <button class="btn btn-primary btn-block" type="submit">Tambahkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->


                    </div>
                </div>

            </div>

    <?php
        endwhile;
    } else {
        if (empty($_GET['keyword'])) {
            $kategori = pilter($kon,$_POST['sort']);
  
            if($kategori === 'all') {
               $notice = 'Belum ada produk silahkan tambah produk';
            } else if ($kategori === 'recomended') {
                $notice = "Tidak ada menu di kategori $kategori";
            } else if ($kategori === 'makanan') {
                $notice = "Tidak ada menu di kategori $kategori ";
            } else if ($kategori === 'minuman') {
                $notice = "Tidak ada menu di kategori $kategori ";
            }else {
                $notice = "Belum ada produk silahkan tambah produk";
            }

            echo "
                    <div class='container' style='margin-top:20%'> 
                    <div class='row'>
                    <div class='col lg-12'>
                        <center>
                             <span class='ml-3 text-secondary'>$notice</span>
                               <br>
                             <a href='tambahproduk' class='btn btn-outline-primary mt-3'> <i class='fa fa-plus'></i>  Tambah produk</a>
                        </center>
                    </div>
                    </div>
                    </div> 
                  ";
        } else {
            $pencarian = pilter($kon,$_GET['keyword']);
            echo "
                    <div class='container' style='margin-top:20%'> 
                    <div class='row'>
                    <div class='col lg-12'>
                        <center>
                             <span class='ml-3 text-secondary'>$pencarian tidak ada di menu!</span>
                        </center>
                    </div>
                    </div>
                    </div> 
                  ";
        } 
    };
    ?>
</div>



