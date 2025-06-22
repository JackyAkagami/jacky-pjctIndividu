<?php
session_start();
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}
include 'koneksi.php';

$id_dokter = $_SESSION['id_dokter'];
$tanggal = date('Y-m-d'); // Tampilkan hanya hari ini

$q = mysqli_query($conn, "
    SELECT s.*, p.nama, p.alamat, p.no_hp
    FROM pemeriksaan_selesai s
    JOIN pasien p ON s.id_pasien = p.id_pasien
    WHERE s.id_dokter = '$id_dokter'
    AND DATE(selesai_pada) = '$tanggal'
    ORDER BY s.selesai_pada DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Riwayat Pemeriksaan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Riwayat Pasien Selesai (<?= date('d/m/Y') ?>)</h2>
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
<?php while ($row = mysqli_fetch_assoc($q)) { ?>
<tr>
  <td><?= $row['nama'] ?></td>
  <td><?= $row['alamat'] ?></td>
  <td><?= $row['no_hp'] ?></td>
  <td><?= $row['tanggal'] ?></td>
  <td><?= $row['jam'] ?></td>
  <td><?= $row['keluhan'] ?></td>
  <td><?= $row['selesai_pada'] ?></td>
</tr>
<?php } ?>
</table>
<br>
<a href="cetak_riwayat.php" target="_blank">🖨️ Cetak PDF</a>
<a href="jadwal_dokter.php">← Kembali</a>
</body>
</html>
