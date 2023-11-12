<?php
session_start();

unset($_SESSION['loginku']);
unset($_SESSION['user']);
unset($_SESSION['resto']);
unset($_SESSION['jabatan']);
unset($_SESSION['keranjang_belanja']);
unset($_SESSION['noinv']);
header("Location: login");