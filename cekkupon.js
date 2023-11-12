var datakupon = document.getElementById('datakupon');
var validasikupon = document.getElementById('validasikupon');

//tambahkan event ketika keyword di ketik
datakupon.addEventListener('keyup', function() {

    //buat oject ajax
    var xhr =new XMLHttpRequest();
    
    //cek kesiapan ajax
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200)  {
            //tampilkan data dari file.php
            validasikupon.innerHTML = xhr.responseText;
        }
    }

     //ekseskusi ajax metode GET & ambil isi dari file.php sambil mengirim value dari inputan field keyword
     xhr.open('GET', 'validasikupon?datakupon=' + datakupon.value, true);
     xhr.send();


});
