
        // shortut adalah button
    var shortcut = document.getElementById('shortcut1');

    //tampilPromo adalah 
    var tampilPromo = document.getElementById('tampilPromo2');

    //tambahkan event ketika keyword di ketik
    shortcut.addEventListener('click', function() {

        //buat oject ajax
        var xhr =new XMLHttpRequest();
        
        //cek kesiapan ajax
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200)  {
                //tampilkan data dari file.php
                tampilPromo.innerHTML = xhr.responseText;
            }
        }

        //ekseskusi ajax metode GET & ambil isi dari file.php sambil mengirim value dari inputan field keyword
        xhr.open('GET', 'shortcut-Promo.php?shortcut1=' + shortcut.value, true);
        xhr.send();

    });

         // shortut adalah button
         var shortcut = document.getElementById('shortcut2');

         //tampilPromo adalah 
         var tampilPromo = document.getElementById('tampilPromo2');
     
         //tambahkan event ketika keyword di ketik
         shortcut.addEventListener('click', function() {
     
             //buat oject ajax
             var xhr =new XMLHttpRequest();
             
             //cek kesiapan ajax
             xhr.onreadystatechange = function() {
                 if(xhr.readyState == 4 && xhr.status == 200)  {
                     //tampilkan data dari file.php
                     tampilPromo.innerHTML = xhr.responseText;
                 }
             }
     
             //ekseskusi ajax metode GET & ambil isi dari file.php sambil mengirim value dari inputan field keyword
             xhr.open('GET', 'shortcut-Promo.php?shortcut2=' + shortcut.value, true);
             xhr.send();
     
         });


       






