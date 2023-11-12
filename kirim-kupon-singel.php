<?php
 session_start();
 require 'koneksi.php';
 require 'function.php';

 #buat kode kupon
 #buat random id (untuk id_invoice & id_trx)
      // Acak 8 digit text dan angka
   $random = "";
   for ($i = 0; $i < 10; $i++) {
         $randomChar = chr(rand(49, 122)); // acak karakter ASCII antara 49 (1) dan 122 (z)
         if (is_numeric($randomChar) || preg_match("/[a-z]/", $randomChar)) {
            $random .= $randomChar;
         } else {
            $i--;
         }
            $kuponnya = pilter($kon,$random);
   }

    use PHPMailer\PHPMailer\PHPMailer;
    require 'PHPMailer/src/PHPMailer.php'; 
    require 'PHPMailer/src/SMTP.php'; 
    require 'PHPMailer/src/Exception.php';

    if(isset($_POST['btnsingelmail'])) {

    $emailpengirim = piltermail($kon,$_POST['emailpengirim']);
    $token = pilter($kon,$_POST['token']);
    $subject = pilter($kon,$_POST['subject']);
    $isiemail = pilter($kon,$_POST['isiemail']);
    $potongan = pilter($kon,$_POST['potongan']);
    $tipe = pilter($kon,$_POST['tipe']);
    $email = piltermail($kon,$_POST['email']);

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
    $mail->Username = ($emailpengirim);
    $mail->Password = ($token);
    $mail->setFrom    ($emailpengirim, 'KuponPromo');    //pengirim
    $mail->addReplyTo ($emailpengirim, 'KuponPromo');
    $mail->AddAddress ($email);  //email dan nama penerima
    $mail->Subject =  ($subject);
    $mail->isHTML(true);

    $mail->Body = ($isiemail.' '.$kuponnya); 
    
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
       } else {
        #masukan kode kuponke tabel kupon
        mysqli_query($kon,"INSERT INTO kupon (kode,resto,potongan,tipe,status) VALUES ('$kuponnya','$_SESSION[resto]',' $potongan','$tipe','aktif') ");

        header("Location: customer");
        $_SESSION['kirimemail'] = 'terkirim';
       }
    
 }else {
    #kembali ke hal customer
 }


?>