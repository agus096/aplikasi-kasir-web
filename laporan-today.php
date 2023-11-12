<?php
 session_start();
 require 'koneksi.php';
 include 'header.php';
?>

<div class="container mt-4">

<label for="from">From:</label>
<input type="text" id="from" name="from">
<label for="to">To:</label>
<input type="text" id="to" name="to">

<table id="datatable">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th id="date-column">Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>John Doe</td>
      <td>Jl. Example</td>
      <td>2022-01-01</td>
    </tr>
    <tr>
      <td>2</td>
      <td>Jane Doe</td>
      <td>Jl. Example</td>
      <td>2022-01-02</td>
    </tr>
  </tbody>
</table>
</div>


<?php include 'footer.php' ?>