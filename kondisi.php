<?php 
  session_start()
?>

<a href="clear-cart.php" class="btn btn-primary btn-lg ml-1" style="width: 32%;"><i class="fa-solid fa-repeat"></i> Transaksi baru</a>

<button class="btn btn-primary btn-lg ml-2 " style="width: 32%;" disabled>
  <i class="fa-sharp fa-solid fa-check-to-slot"></i> Tersimpan!
</button>

<?php
  $_SESSION['noinv'] = 'ada';
?>

