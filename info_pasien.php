<?php
session_start(); //Memulai session
// Cek apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");// Jika tidak login, redirect ke login.php
    exit; // Hentikan eksekusi skrip
}
include 'koneksi.php';// Hubungkan ke database

// Ambil ID pasien dari URL (parameter GET)
$id = $_GET['id'] ?? 0; // Jika tidak ada, default ke 0
echo "ID DITERIMA: $id<br>"; // Debug: menampilkan ID di halaman (boleh dihapus)


// Query untuk mengambil data pasien berdasarkan ID
$q = mysqli_query($conn, "SELECT * FROM pasien WHERE id_pasien = '$id'");
$data = mysqli_fetch_assoc($q); // Ambil data pasien sebagai array

// Jika data tidak ditemukan, tampilkan alert dan redirect
if (!$data) {
    echo "<script>alert('Data tidak ditemukan'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Informasi Pasien</title>
    <link rel="stylesheet" href="style.css"> <!-- Menghubungkan file CSS -->
</head>
<body>
<div class="container">
    <h2>Detail Informasi Pasien</h2>
    <!-- Tabel menampilkan informasi pasien -->
    <table>
        <tr><th>Nama</th><td><?= $data['nama'] ?></td></tr>
        <tr><th>Alamat</th><td><?= $data['alamat'] ?></td></tr>
        <tr><th>No HP</th><td><?= $data['no_hp'] ?></td></tr>
    </table>
    <br>
    <!-- Tombol kembali ke halaman utama -->
    <a href="index.php">Kembali</a>
</div>
</body>
</html>
