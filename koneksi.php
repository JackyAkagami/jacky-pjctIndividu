<?php
// Menyimpan alamat host database (biasanya "localhost" untuk server lokal)
$host = "localhost";
// Menyimpan nama pengguna untuk login ke MySQL (default: "root")
$user = "root";
// Menyimpan password MySQL (kosong karena default XAMPP tidak pakai password)
$pass = "";
// Menyimpan nama database yang ingin digunakan (dalam hal ini: db_klinik)
$db   = "db_klinik";
// Membuat koneksi ke database menggunakan fungsi mysqli_connect()
// Jika gagal, tampilkan pesan error dan hentikan eksekusi program
$conn = mysqli_connect($host, $user, $pass, $db)
        or die("Koneksi gagal: " . mysqli_connect_error());
?>
