<?php
session_start();
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}
include 'koneksi.php';
$id_dokter = $_SESSION['id_dokter'];

// Ambil nama dokter
$dokter = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_dokter FROM dokter WHERE id_dokter='$id_dokter'"))['nama_dokter'];

// Ambil data pemeriksaan dokter ini
$q = mysqli_query($conn, "SELECT p.*, pa.nama AS nama_pasien 
                          FROM pemeriksaan p 
                          JOIN pasien pa ON p.id_pasien = pa.id_pasien 
                          WHERE p.id_dokter = '$id_dokter'
                          ORDER BY p.tanggal, p.jam");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Jadwal Dokter</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Jadwal Pemeriksaan Dokter <?= $dokter ?></h2>
<table border="1" cellpadding="8">
<tr>
  <th>Pasien</th>
  <th>Tanggal</th>
  <th>Jam</th>
  <th>Keluhan</th>
  <th>Selesaikan</th>
</tr>
<?php while ($row = mysqli_fetch_assoc($q)) { ?>
<tr>
  <td><?= $row['nama_pasien'] ?></td>
  <td><?= $row['tanggal'] ?></td>
  <td><?= $row['jam'] ?></td>
  <td><?= $row['keluhan'] ?></td>
  <td>
  <a href='selesaikan.php?id=<?= $row['id_periksa'] ?>' 
     onclick="return confirm('Tandai sebagai selesai?')">Selesai</a>
</td>

</tr>
<?php } ?>
</table>
<br>
<a href="riwayat_selesai.php">Lihat Riwayat</a>
<a href="logout_dokter.php">Logout</a>
</body>
</html>
