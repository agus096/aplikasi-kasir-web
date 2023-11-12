<?php require 'koneksi.php' ?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

<!-- datatables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/dt-1.13.1/af-2.5.1/b-2.3.3/cr-1.6.1/date-1.2.0/fh-3.3.1/r-2.4.0/sl-1.5.0/sr-1.2.0/datatables.min.css"/>



<table class="display datatable-ajax"style="width:100%">
    <thead>
        <tr>
            <th>Id invoice</th>
            <th>Status</th>
            <th>Detail</th>
        </tr>
    </thead>
</table>
<button id="buttonku">Sinkron</button>

<div id="modalku"></div>



<?php include 'footer.php' ?>


