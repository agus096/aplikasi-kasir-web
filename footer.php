<!-- bootstrap 4.0.0 min.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<!-- Jquery 3.6.1 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"></script>
<!-- js jquery ui -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Jquery popper.js@1.12.9 -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<!-- datatables js -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/date-1.2.0/fc-4.2.1/fh-3.3.1/kt-2.8.0/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/sr-1.2.0/datatables.min.js"></script>
<!-- selectize js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
<!-- script ajax pencarian -->
<script src="ajax.js"></script>
<!-- script cek kupon -->
<script src="cekkupon.js"></script>
<!-- script tampil gambar -->
<script src="tampilgambar.js"></script>
<!-- script ajax pencarian -->
<script src="recomended.js"></script>
<!--sweet alert js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<!-- JavaScript for datatables Buttons -->
<script src="https://cdn.datatables.net/buttons/1.6.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.3/js/buttons.print.min.js"></script>

<!-- Excel & PDF -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.js"></script>


<!-- reqular exresion REGEX untuk semua form alias form-control bootstrap -->
<script>
    const elements = document.querySelectorAll('.form-control');
    elements.forEach(element => {
    element.addEventListener('keyup', function() {
        this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '')
        .replace(/LIMIT|select|src|True|false|JOIN|UNION|FROM|Like|1=1|TABLE|DROP|TRUNCATE|delete|update|insert|into|ORDER|BY|Query|database|user|admin|hostname|tmpdir|datadir|basedir|information|schema|session_user|session|group|concat|coloum|password|0x|<script>|script|alert|function|window|iframe|document|header|location|cookie|html/gi, '');
    });
    });
</script>

<!-- mengikat table dengan datatable & Menambahkan fittur plugin button -->
<script>
$(document).ready( function () {
    var table = $('#datatable').DataTable({
        dom: 'Bfrtip', // menambahkan kontrol tombol
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print' // menambahkan tombol import dan cetak
        ],
        initComplete: function(settings) {
            // menambahkan event listener pada form pencarian untuk menghilangkan karakter berbahaya
            $('#datatable_filter input').on('keyup', function() {
                // menyaring input pencarian
                var search = $(this).val().replace(/[^a-z0-9]/gi, '');
                $(this).val(search);
            });
        }
    });

    // menambahkan kolom tanggal untuk filter
    table.columns().every( function () {
        var that = this;
        $( '#date-column input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        });
    });
});
</script>




<!-- jquery double membuat konflik karena itu dibuat $j -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- menampilkan nama berdasarkan no.WA -->
<script type="text/javascript">
        var $j = jQuery.noConflict();
        function isi_otomatis(){
        var wa = $("#wa").val();
        $j.ajax({
                url: 'tampilkan-nama.php',
                data:"wa="+wa ,
        }).success(function (data) {
                var json = data,
                obj = JSON.parse(json);
                $('#nama').val(obj.nama);
                $('#email').val(obj.email);
        });
        }
</script>


<!-- selectize -->
<script>
$('.selectize').selectize({
	plugins: ['remove_button'],
	sortField: 'text'
});
</script>

<!-- format field ke rupiah -->
<script>
    /* Dengan Rupiah https://codepen.io/chucky25/pen/dBevXW */
    var dengan_rupiah = document.getElementById('dengan-rupiah');
    dengan_rupiah.addEventListener('keyup', function(e) {
        dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>

<!-- uncheck radio promo -->
<script>
var allRadios = document.getElementsByName('kodepromo');
var booRadio;
var x = 0;
for(x = 0; x < allRadios.length; x++){

        allRadios[x].onclick = function(){

            if(booRadio == this){
                this.checked = false;
        booRadio = null;
            }else{
            booRadio = this;
        }
        };

}
</script>

<!-- datatables dengan ajax -->
<!-- https://datatables.net/reference/api/ajax.reload() -->
<script>
    var table = $('.datatable-ajax').DataTable( {
        ajax: 'data-invoice.php',
        columns: [
            { data: 'id_trx'},
            { data: 'status'},
            { data: 'button'}
        ],
    });
setInterval( function () {
    table.ajax.reload();
}, 3000 );
</script>

<!-- ajax hal. orderan -->
<script>
    function loadlink(){
        $('#orderan').load('isi-orderan.php',function () {
            $(this).unwrap();
        });
    }

    loadlink(); // This will run on page load
    setInterval(function(){
        loadlink() // this will run after every 5 seconds
    }, 3000);
</script>




<!-- ajax kondisi button print sudah di klik -->
<script>
        var buttonku = document.getElementById('buttonku');
        var kondisi = document.getElementById('kondisi');

        //tambahkan event ketika keyword di ketik
        buttonku.addEventListener('click', function() {

            //buat oject ajax var (xhr) bebas mau apa aja nama variable nya

            var xhr =new XMLHttpRequest();
            
            //cek kesiapan ajax 4 (ajax ready) 200 (status server ok)
            xhr.onreadystatechange = function() {
                if(xhr.readyState == 4 && xhr.status == 200)  {
                    //tampilkan data dari file.php
                    kondisi.innerHTML = xhr.responseText;
                }
            }

            //ekseskusi ajax metode GET & ambil isi dari file.php sambil mengirim value dari inputan field keyword
            xhr.open('GET', 'kondisi.php', true);
            xhr.send();
        });
</script>

<!-- js untuk navbar -->

<script>
    // ---------Responsive-navbar-active-animation-----------
function test(){
	var tabsNewAnim = $('#navbarSupportedContent');
	var selectorNewAnim = $('#navbarSupportedContent').find('li').length;
	var activeItemNewAnim = tabsNewAnim.find('.active');
	var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
	var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
	var itemPosNewAnimTop = activeItemNewAnim.position();
	var itemPosNewAnimLeft = activeItemNewAnim.position();
	$(".hori-selector").css({
		"top":itemPosNewAnimTop.top + "px", 
		"left":itemPosNewAnimLeft.left + "px",
		"height": activeWidthNewAnimHeight + "px",
		"width": activeWidthNewAnimWidth + "px"
	});
	$("#navbarSupportedContent").on("click","li",function(e){
		$('#navbarSupportedContent ul li').removeClass("active");
		$(this).addClass('active');
		var activeWidthNewAnimHeight = $(this).innerHeight();
		var activeWidthNewAnimWidth = $(this).innerWidth();
		var itemPosNewAnimTop = $(this).position();
		var itemPosNewAnimLeft = $(this).position();
		$(".hori-selector").css({
			"top":itemPosNewAnimTop.top + "px", 
			"left":itemPosNewAnimLeft.left + "px",
			"height": activeWidthNewAnimHeight + "px",
			"width": activeWidthNewAnimWidth + "px"
		});
	});
}
$(document).ready(function(){
	setTimeout(function(){ test(); });
});
$(window).on('resize', function(){
	setTimeout(function(){ test(); }, 500);
});
$(".navbar-toggler").click(function(){
	$(".navbar-collapse").slideToggle(300);
	setTimeout(function(){ test(); });
});



// --------------add active class-on another-page move----------
jQuery(document).ready(function($){
	// Get current path and find target link
	var path = window.location.pathname.split("/").pop();

	// Account for home page with empty path
	if ( path == '' ) {
		path = 'index.html';
	}

	var target = $('#navbarSupportedContent ul li a[href="'+path+'"]');
	// Add active class to target link
	target.parent().addClass('active');
});




// Add active class on another page linked
// ==========================================
// $(window).on('load',function () {
//     var current = location.pathname;
//     console.log(current);
//     $('#navbarSupportedContent ul li a').each(function(){
//         var $this = $(this);
//         // if the current path is like this link, make it active
//         if($this.attr('href').indexOf(current) !== -1){
//             $this.parent().addClass('active');
//             $this.parents('.menu-submenu').addClass('show-dropdown');
//             $this.parents('.menu-submenu').parent().addClass('active');
//         }else{
//             $this.parent().removeClass('active');
//         }
//     })
// });
</script>



<script>
    const button = document.getElementById("buttonku");
const sound = new Audio("bellku.mp3");

button.addEventListener("click", function() {
  sound.play();
});
</script>

