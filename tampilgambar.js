var inputurl = document.getElementById('inputurl');
var tampilgambar = document.getElementById('tampilgambar');

//tambahkan event ketika inputurl di ketik
inputurl.addEventListener('keyup', function() {

    //buat oject ajax
    var xhr =new XMLHttpRequest();
    
    //cek kesiapan ajax
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200)  {
            //tampilkan data dari file.php
            tampilgambar.innerHTML = xhr.responseText;
        }
    }

     //ekseskusi ajax metode GET & ambil isi dari file.php sambil mengirim value dari inputan field inputurl
     xhr.open('GET', 'isigambar?inputurl=' + inputurl.value, true);
     xhr.send();


});
