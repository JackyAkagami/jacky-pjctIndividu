<?php
// Memulai session untuk memastikan user sudah login
session_start();
// Jika session 'login' belum ada, arahkan user ke halaman login dan hentikan script
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
// Menghubungkan ke database dengan file koneksi.php
include 'koneksi.php';
// Mengambil seluruh data dari tabel 'dokter' di database 

$dokter = mysqli_query($conn, "SELECT * FROM dokter");
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Judul halaman yang muncul di tab browser -->
  <title>Daftar Dokter Tetap</title>
  <!-- Menyisipkan file CSS untuk styling -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <!-- Judul utama halaman -->
  <h2>Dokter Tetap Klinik Sehat</h2>

  <!-- Membuat tabel untuk menampilkan data dokter -->
  <table>
    <tr>
      <th>Foto</th>
      <th>Nama Dokter</th>
      <th>Spesialis</th>
    </tr>
    <!-- Looping untuk menampilkan setiap baris data dokter -->
    <?php while ($d = mysqli_fetch_assoc($dokter)) { ?>
      <tr>
      <!-- Menampilkan foto dokter -->
      <td>
        <img src="foto_dokter/<?= $d['foto'] ?>" alt="foto" width="100" height="120">
      </td>
        <!-- Menampilkan nama dokter -->
        <td><?= $d['nama_dokter'] ?></td>
        <!-- Menampilkan spesialisasi dokter -->
        <td><?= $d['spesialis'] ?></td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <!-- Link untuk kembali ke halaman beranda/index -->
  <a href="index.php">Kembali ke Beranda</a>
</div>
</body>
</html>

