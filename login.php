<?php
 session_start();

 #konek DB
 require 'koneksi.php';
 require 'function.php';

  //jika button login di klik
  if (isset($_POST['log'])) {
      $resto = pilter($kon,$_POST['resto']);
      $user = pilter($kon,$_POST['user']);
      $pascode = pilter($kon,md5($_POST['pascode']));

        #cek apakah ada kecocokan row 
        #buat prepare statement
        $stmt = mysqli_prepare($kon, "SELECT * FROM userku WHERE resto= ? AND user = ? AND pascode = ?");

        #lakukan bind pada paramenter
        mysqli_stmt_bind_param($stmt, "sss",$resto, $user, $pascode);

        #eksekusi statement
        mysqli_stmt_execute($stmt);
        $listuser = mysqli_stmt_get_result($stmt);

        #fetch untuk mendapatkan jabatan
        $datauser = mysqli_fetch_array($listuser);
        if(mysqli_num_rows($listuser) > 0 ) {
        #jika ada buat sesion
            $_SESSION['loginku'] = 'login';
            $_SESSION['user'] = $user;
            $_SESSION['resto'] = $datauser['resto'];
            $_SESSION['jabatan'] = $datauser['jabatan'];
            header("Location: beranda");
        } else {
            $pesangagallog = "<div class='alert alert-danger'>Data tidak ada atau mungkin salah!</div>";
        } 
    } 
    
    

//Jika button register di klik 
if(isset($_POST['reg'])) {
   $resto = pilter($kon,$_POST['resto']);
   $email = piltermail($kon,$_POST['email']);
   $username = pilter($kon,$_POST['username']);
   $pascode = pilter($kon,md5($_POST['pascode']));


   //if nama resto sudah ada, kick
   $cekresto = mysqli_query($kon,"SELECT * FROM userku WHERE resto = '$resto' ") ;
   if (mysqli_num_rows($cekresto) > 0) {
        $pesangagalregresto = "<div class='alert alert-danger'>Data sudah di gunakan!</div>";
   } 
     //else lakukan ceking menyeluruh
     else {
       
        //cek apakah sudah ada resto , username & email tersebut
      $cekuser = mysqli_query($kon,"SELECT * FROM userku WHERE resto = '$resto' AND email ='$email' AND user = '$username' ") ;
      if (mysqli_num_rows($cekuser) > 0) {
          $pesangagalreg = "<div class='alert alert-danger'>Data sudah di gunakan!</div>";
      } 
      else {
      //jika data valid (belum ada yang menggunakan daftarkan akun ke database)
      #buat statement
      $stmt = $kon->prepare("INSERT INTO userku SET resto = ?, email = ?, user = ?, pascode = ?");
      #lakukan bind
      $stmt->bind_param("ssss", $resto, $email, $username, $pascode);
      #eksekusi statement
      $stmt->execute();
      $pesanberhasilregist = "<div class='alert alert-success'>Akun berhasil di buat! simpan data login ada & silahkan masuk.</div>";

      } 
   } 


}
  
?>

<?php include 'header.php'; ?>

<style>
    body{
    margin-top:20px;
    background-image: url('https://i.ibb.co/dPF0m4P/pexels-tim-douglas-6205626.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
.container {
    margin-right: auto;
    margin-left: auto;
    padding-right: 15px;
    padding-left: 15px;
    width: 100%;
}

@media (min-width: 576px) {
    .container {
        max-width: 540px;
    }
}

@media (min-width: 768px) {
    .container {
        max-width: 720px;
    }
}

@media (min-width: 992px) {
    .container {
        max-width: 960px;
    }
}

@media (min-width: 1200px) {
    .container {
        max-width: 1140px;
    }
}



.card-columns .card {
    margin-bottom: 0.75rem;
}

@media (min-width: 576px) {
    .card-columns {
        column-count: 3;
        column-gap: 1.25rem;
    }
    .card-columns .card {
        display: inline-block;
        width: 100%;
    }
}
.text-muted {
    color: #9faecb !important;
}

p {
    margin-top: 0;
    margin-bottom: 1rem;
}
.mb-3 {
    margin-bottom: 1rem !important;
}

.input-group {
    position: relative;
    display: flex;
    width: 100%;
}
</style>


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<br>
<br>
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <div class="card-body">
              <h1>Masuk</h1>
              <p class="text-muted">Masuk ke akun anda</p>

            <!-- jika pesangagal tidak kosong -->
            <?php 
                   if(!empty($pesangagallog)){
                       echo $pesangagallog;
                   } 
            ?>
            <form action="" method="POST">
              <div class="input-group mb-3">
                <span class="input-group-addon"><i class="fa-solid fa-utensils"></i></span>
                <input type="text" name="resto" class="form-control" placeholder="Nama resto" required>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="user" class="form-control" placeholder="Username" required>
              </div>
              <div class="input-group mb-4">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" name="pascode" class="form-control" placeholder="Password" required>
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="submit" name="log" class="btn btn-primary px-4">Masuk</button>
                </div>
            </form>

              </div>
            

            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Daftar</h2>

               <!-- jika pesangagal tidak kosong -->
              <?php  
                      if(!empty($pesangagalregresto))  {
                       echo $pesangagalregresto;
                      } 

                      if(!empty($pesangagalreg))  {
                        echo $pesangagalreg;
                       } 

                      if(!empty($pesanberhasilregist)) {
                        echo $pesanberhasilregist;
                      }
              ?>
              <form action="" method="POST">
                <div class="input-group mb-4">
                  <span class="input-group-addon"><i class="fa-solid fa-utensils"></i></span>
                  <input type="text" name="resto" class="form-control" placeholder="nama resto" required>
                </div>

                <div class="input-group mb-4">
                  <span class="input-group-addon"><i class="fa-solid fa-envelope"></i></span>
                  <input type="email" name="email" class="form-control-noregex" placeholder="Email" style=" margin-top: -10px; border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: 20px;" required>
                </div>
                
                <div class="input-group mb-4">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
              
                <div class="input-group mb-4">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="text" name="pascode" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" name="reg" class="btn btn-primary active mt-3">Daftar sekarang!</button>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col lg-12">
       <center><span class="text-white" style="font-family: Miguelito; font-size:65px;">KasirGratis</span></center> 
      </div>
    </div>

    <div class="row" style="margin-top:15%;">
      <div class="col lg-12">
       <center><span class="text-white">© Photo by Tim Douglas : https://www.pexels.com/photo/man-making-coffee-6205626/</span></center> 
      </div>
    </div>
   
  </div>

  <?php include 'footer.php' ?>