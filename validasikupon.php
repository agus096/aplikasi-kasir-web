<?php
session_start();
require 'koneksi.php';
require 'function.php';
$datakupon = pilter($kon,$_GET['datakupon']);

$cekkupon = mysqli_query($kon,"SELECT * from kupon WHERE kode = '$datakupon' AND resto = '$_SESSION[resto]' ");
$data = mysqli_fetch_array($cekkupon);
if (mysqli_num_rows($cekkupon) > 0 && $data['status'] == 'aktif') {
    echo "<span class='text-success'>Valid!</span>";
}else if (mysqli_num_rows($cekkupon) > 0 && $data['status'] == 'nonaktif') {
    echo "<span class='text-warning'>Kadaluarsa!</span>";
}else {
    echo "<span class='text-danger'>Tidak valid!</span>";
}