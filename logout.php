<?php
// Memulai session agar bisa mengakses dan menghapus data session yang aktif
session_start();
// Menghapus semua data session yang tersimpan (logout)
session_destroy();
// Mengarahkan (redirect) user kembali ke halaman login
header("Location: login.php");
exit; // Menghentikan eksekusi script agar tidak lanjut ke baris berikutnya
?>
