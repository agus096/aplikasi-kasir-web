<?php 
    session_start();

    if(empty($_SESSION['loginku'])) {
      header("Location: login");
    }

    include 'header.php';
    require 'koneksi.php';
    require 'function.php';
  
    if (isset($_POST['kategori']) && pilter($kon, $_POST['kategori']) === 'makanan' ) {
      $_SESSION['sortboard'] = " AND kategori = 'makanan'  ";
    } else if (isset($_POST['kategori']) && pilter($kon, $_POST['kategori']) === 'minuman' )  {
      $_SESSION['sortboard'] = " AND kategori = 'minuman'  ";
    }else if (isset($_POST['kategori']) && pilter($kon, $_POST['kategori']) === 'semua' )  {
      $_SESSION['sortboard'] = " ";  
    }else {
      $_SESSION['sortboard'] = " ";
    } 
    
?>

<style>
    @font-face {
        font-family: write;
        src: url(font/lio.otf);
      }
    .card {
        display:inline-block;
        background-image: url("https://i.ibb.co/M55mmYL/marjan-blan-marjanblan-k-Ux-T8-Wkoe-Y-unsplash.jpg");
        background-color: #cccccc;
      }
      .write {
        font-family: write;
        font-size: 900px;
      }
   
</style>

<div class="container-fluid">

    <div class="alert alert-primary m-3" role="alert">
      Halaman ini menampilkan invoice tiap orderan dengan fitur auto refresh jika ada orderan 
    </div>

    <!-- kembali ke home -->
    <a href="/cart" class="ml-3 btn btn-secondary mt-3">Back</a>
    <a href="/cart/orderan" class="ml-3 btn btn-light mt-3">List</a>

    <!-- sortir makanan atau minuman yang akan di tampilkan -->
    <form action=" " method="POST">
      <select name="kategori" class="selectize mb-3 mt-3 ml-3" onchange="this.form.submit();" style="width:100px;"  >
          <option>--Sortir--</option>
          <option value="semua">Semua</option>
          <option value="minuman">Minuman</option>
          <option value="makanan">Makanan</option>
      </select>
    </form>

    <div class="ml-3" id="orderan"></div>


</div>

<?php require 'footer.php' ?>