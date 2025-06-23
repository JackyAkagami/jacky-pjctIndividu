<?php
session_start(); // Memulai session PHP untuk menggunakan data login dokter
// Jika belum login sebagai dokter, redirect ke halaman login
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php"); // Arahkan ke login_dokter.php jika session belum tersedia
    exit; // Hentikan eksekus
}
include 'koneksi.php'; // Hubungkan ke file koneksi untuk akses database

$id_dokter = $_SESSION['id_dokter']; // Ambil ID dokter dari session login
$tanggal = date('Y-m-d'); // Ambil tanggal hari ini dalam format Y-m-d (misal: 2025-06-25)

// Query untuk mengambil data dari tabel pemeriksaan_selesai yang hanya dilakukan hari ini
          $q = mysqli_query($conn, "
              SELECT s.*, p.nama, p.alamat, p.no_hp
              FROM pemeriksaan_selesai s
              JOIN pasien p ON s.id_pasien = p.id_pasien
              WHERE s.id_dokter = '$id_dokter'
              AND DATE(selesai_pada) = '$tanggal'
              ORDER BY s.selesai_pada DESC
          ")
        ; // Ambil semua data dari tabel pemeriksaan_selesai dan data pasien
        // Tabel utama: pemeriksaan_selesai dengan alias s
        // Gabungkan dengan tabel pasien berdasarkan id_pasien
        // Filter hanya data dari dokter yang sedang login
        // Tampilkan hanya data yang diselesaikan pada tanggal hari ini
        // Urutkan dari yang paling baru selesai ke yang lama

?>

<!DOCTYPE html>
<html>
<head>
  <title>Riwayat Pemeriksaan</title>
  <link rel="stylesheet" href="style.css"> <!-- Memanggil file CSS eksternal -->
</head>
<body>
  <!-- Judul halaman dan tanggal ditampilkan -->
<h2>Riwayat Pasien Selesai (<?= date('d/m/Y') ?>)</h2>
<!-- Tabel untuk menampilkan riwayat pasien selesai -->
<table border="1" cellpadding="8">
<tr>
  <th>Nama</th>
  <th>Alamat</th>
  <th>No HP</th>
  <th>Tanggal</th>
  <th>Jam</th>
  <th>Keluhan</th>
  <th>Diselesaikan Pada</th>
</tr>
<?php 
// Menampilkan setiap baris hasil query ke dalam tabel
while ($row = mysqli_fetch_assoc($q)) { ?>
<tr>
  <td><?= $row['nama'] ?></td> <!-- Nama pasien -->
  <td><?= $row['alamat'] ?></td> <!-- Alamat pasien -->
  <td><?= $row['no_hp'] ?></td> <!-- Nomor HP pasien -->
  <td><?= $row['tanggal'] ?></td> <!-- Tanggal pemeriksaan -->
  <td><?= $row['jam'] ?></td> <!-- Jam pemeriksaan -->
  <td><?= $row['keluhan'] ?></td> <!-- Keluhan pasien -->
  <td><?= $row['selesai_pada'] ?></td> <!-- Waktu selesai pemeriksaan -->
</tr>
<?php } ?>
</table>
<br>
<!-- Tombol untuk mencetak PDF dan kembali ke jadwal dokter -->
<a href="cetak_riwayat.php" target="_blank">🖨️ Cetak PDF</a>
<a href="jadwal_dokter.php">← Kembali</a>
</body>
</html>
