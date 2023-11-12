var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var hasilcari = document.getElementById('hasilcari');

//tambahkan event ketika keyword di ketik
keyword.addEventListener('keyup', function() {

    //buat oject ajax
    var xhr =new XMLHttpRequest();
    
    //cek kesiapan ajax
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200)  {
            //tampilkan data dari file.php
            hasilcari.innerHTML = xhr.responseText;
        }
    }

     //ekseskusi ajax metode GET & ambil isi dari file.php sambil mengirim value dari inputan field keyword
     xhr.open('GET', 'produk.php?keyword=' + keyword.value, true);
     xhr.send();


});
