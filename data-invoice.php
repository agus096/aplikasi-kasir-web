<?php 
header('Content-Type: application/json; charset=utf8');
require 'koneksi.php';

//query tabel produk
$query=mysqli_query($kon,"SELECT * FROM invoice");

//data array
$array=array();
while($data=mysqli_fetch_array($query)) $array[]=$data; 

//mengubah data array menjadi json
echo json_encode(array('data' => $array));

?>




