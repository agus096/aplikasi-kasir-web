<?php

require 'koneksi.php';

//variabel wa yang dikirimkan dari form
$wa = $_GET['wa'];

//mengambil data
$query = mysqli_query($kon, "SELECT * from customer WHERE wa ='$wa'");
$tampilkan  = mysqli_fetch_array($query);
$data = array(
               'nama' =>  @$tampilkan['nama'] ,
               'email' =>  @$tampilkan['email']
        );

//tampil data
echo json_encode($data);
?>

