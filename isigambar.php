<?php

 require 'koneksi.php';
 require 'function.php';

  #sesi menangani URL
  $url       = pilterurl($kon,filter_var($_GET['inputurl'], FILTER_VALIDATE_URL)) ;

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
  // URL berasal dari situs ibb.co
  echo "<img src='$url' width='100px'>";
  } else {
  echo "Pastikan yang di input sesuai!";
  }
?>

 