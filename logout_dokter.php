<?php
session_start(); // Memulai session untuk mengakses data session yang sedang aktif
session_destroy(); // Menghapus seluruh data session yang tersimpan (logout)
header("Location: login_dokter.php"); // Mengarahkan (redirect) user kembali ke halaman login dokter
?>
