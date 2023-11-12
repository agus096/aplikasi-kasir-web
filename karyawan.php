<?php
 session_start();
 require 'koneksi.php';
 require 'function.php';
 include 'header.php';
?>

<?php include 'navbar.php'?>

<div class="container-fluid mt-5">
   <div class="row">
      <div class="col-lg-6">
        <div class="card card-body card-round">
            <form action="" method="POST">
                <center><b class="h5">Daftarkan akun karyawan</b></center>
                <input type="hidden" name="resto" value="<?= $_SESSION['resto'] ?>" class="form-control" placeholder="nama resto">

                <div class="input-group mb-4">
                    <span class="input-group-addon"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control-noregex" placeholder="Email karyawan" style=" margin-top: -10px; border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: 20px;">
                </div>
                
                <div class="input-group mb-4">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Username karyawan">
                </div>
                
                <div class="input-group mb-4">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="text" name="pascode" class="form-control" placeholder="Password karyawan">
                </div>

                <button type="submit" name="reg" class="btn btn-primary active mt-3 float-right">Daftarkan</button>
            </form>
        </div>
      </div>

      <div class="col-lg-6">
        ...
      </div>
   </div>  
</div>


<?php include 'footer.php' ?>