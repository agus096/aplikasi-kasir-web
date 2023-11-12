<?php
 session_start();
 require 'koneksi.php';
 require 'function.php';


    use PHPMailer\PHPMailer\PHPMailer;
    require 'PHPMailer/src/PHPMailer.php'; 
    require 'PHPMailer/src/SMTP.php'; 
    require 'PHPMailer/src/Exception.php';

    if(isset($_POST['btntestmail'])) {

    $emailpengirim = piltermail($kon,$_POST['emailpengirim']);
    $token = pilter($kon,$_POST['token']);
    $subject = pilter($kon,$_POST['subject']);
    $isiemail = pilter($kon,$_POST['isiemail']);
    $kupon = pilter($kon,$_POST['kupon']);
    $potongan = piltermail($kon,$_POST['potongan']);
    $tipe = piltermail($kon,$_POST['tipe']);
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

    $mail->Body = ($isiemail.' kode kupon nya => '.$kupon.'dan ini adalah test email jika email ini masuk berarti settingan anda sudah tepat dan berjalan..'); 
    
    if (!$mail->send()) {
         header("Location: customer");
         $_SESSION['kirimemail'] = 'gagal';
       } else {
         #masukan kode kuponke tabel kupon
         mysqli_query($kon,"INSERT INTO kupon (kode,resto,potongan,tipe,status) VALUES ('$kupon','$_SESSION[resto]',' $potongan','$tipe','aktif') ");

         header("Location: customer");
         $_SESSION['kirimemail'] = 'terkirim';
       }
    
 }else {
    #kembali ke hal customer
 }


?>