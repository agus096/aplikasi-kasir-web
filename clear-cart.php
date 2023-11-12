<?php
session_start();

unset($_SESSION['keranjang_belanja']);
unset($_SESSION['lanjut']);
unset($_SESSION['sudahdiprint']);
header('location: /cart');