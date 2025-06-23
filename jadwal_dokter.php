<?php
session_start(); // Memulai sesi untuk mengecek apakah dokter sudah login
// Jika dokter belum login, arahkan ke halaman login
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}
include 'koneksi.php'; // Menghubungkan ke database
$id_dokter = $_SESSION['id_dokter']; // Ambil ID dokter yang sedang login dari session

// Ambil nama dokter berdasarkan ID untuk ditampilkan di halaman
$dokter = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_dokter FROM dokter WHERE id_dokter='$id_dokter'"))['nama_dokter'];

// Ambil semua data pemeriksaan yang ditangani oleh dokter ini, gabung dengan data nama pasien
$q = mysqli_query($conn, "SELECT p.*, pa.nama AS nama_pasien 
                          FROM pemeriksaan p 
                          JOIN pasien pa ON p.id_pasien = pa.id_pasien 
                          WHERE p.id_dokter = '$id_dokter'
                          AND p.tanggal >= CURDATE()
                          ORDER BY p.tanggal, p.jam");
                          // Ambil semua kolom dari tabel pemeriksaan dan nama dari tabel pasien
                          // Tabel utama adalah pemeriksaan, alias p
                          // Gabungkan dengan tabel pasien berdasarkan id_pasien
                          // Filter hanya data milik dokter yang sedang login
                          // Tampilkan hanya pemeriksaan hari ini atau setelahnya
                          // Urutkan berdasarkan tanggal dan jam pemeriksaan
?>
<!DOCTYPE html>
<html>
<head>
  <title>Jadwal Dokter</title>
  <link rel="stylesheet" href="style.css"> <!-- Menghubungkan file CSS -->
</head>
<body>
<h2>Jadwal Pemeriksaan Dokter <?= $dokter ?></h2> <!-- Tampilkan nama dokter -->
<!-- Tabel daftar pemeriksaan -->
<table border="1" cellpadding="8">
<tr>
  <th>Pasien</th> <!-- Nama pasien -->
  <th>Tanggal</th> <!-- Tanggal pemeriksaan -->
  <th>Jam</th>  <!-- Jam pemeriksaan -->
  <th>Keluhan</th> <!-- Keluhan pasien -->
  <th>Selesaikan</th> <!-- Tombol untuk menyelesaikan -->
</tr>
<?php while ($row = mysqli_fetch_assoc($q)) { ?> <!-- Loop data pemeriksaan -->
<tr>
  <td><?= $row['nama_pasien'] ?></td> <!-- Kolom nama pasien -->
  <td><?= $row['tanggal'] ?></td> <!-- Kolom tanggal -->
  <td><?= $row['jam'] ?></td> <!-- Kolom jam -->
  <td><?= $row['keluhan'] ?></td> <!-- Kolom keluhan -->
  <td>
        <!-- Tombol selesai, akan menghapus dari tabel pemeriksaan dan memindahkan ke tabel selesai -->
  <a href='selesaikan.php?id=<?= $row['id_periksa'] ?>' 
     onclick="return confirm('Tandai sebagai selesai?')">Selesai</a>
</td>

</tr>
<?php } ?>
</table>
<br>
<a href="riwayat_selesai.php">Lihat Riwayat</a> <!-- Menuju halaman riwayat -->
<a href="logout_dokter.php">Logout</a> <!-- Logout dokter -->
</body>
</html>
