<?php
session_start();
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}
include 'koneksi.php';
$id_dokter = $_SESSION['id_dokter'];

$tanggal_hari_ini = date('Y-m-d');
$q = mysqli_query($conn, "SELECT * FROM pemeriksaan_selesai 
                          WHERE id_dokter='$id_dokter' 
                          AND DATE(selesai_pada) = '$tanggal_hari_ini'
                          ORDER BY selesai_pada DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pemeriksaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Riwayat Pasien Selesai</h2>
<table border="1" cellpadding="8">
<tr>
  <th>Nama Pasien</th><th>Tanggal</th><th>Jam</th><th>Keluhan</th><th>Selesai Pada</th>
</tr>
<?php while ($row = mysqli_fetch_assoc($q)) { ?>
<tr>
  <td><?= $row['nama_pasien'] ?></td>
  <td><?= $row['tanggal'] ?></td>
  <td><?= $row['jam'] ?></td>
  <td><?= $row['keluhan'] ?></td>
  <td><?= $row['selesai_pada'] ?></td>
</tr>
<?php } ?>
</table>
<br>
<a href="cetak_riwayat.php" target="_blank">🖨️ Cetak PDF</a>

<a href="jadwal_dokter.php">Kembali</a>
<h3>Riwayat Pemeriksaan Selesai Tanggal <?= date('d/m/Y') ?></h3>
</body>
</html>
