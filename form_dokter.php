<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Ambil daftar dokter dari database
$dokter = mysqli_query($conn, "SELECT * FROM dokter");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Dokter Tetap</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Dokter Tetap Klinik Sehat</h2>
    <table>
    <tr>
        <th>Foto</th>
        <th>Nama Dokter</th>
        <th>Spesialis</th>
    </tr>
    <?php while ($d = mysqli_fetch_assoc($dokter)) { ?>
    <tr>
        <td>
            <img src="foto_dokter/<?= $d['foto'] ?>" alt="foto" width="100" height="120">
        </td>
        <td><?= $d['nama_dokter'] ?></td>
        <td><?= $d['spesialis'] ?></td>
    </tr>
    <?php } ?>
</table>

    <br>
    <a href="index.php">Kembali ke Beranda</a>
</div>
</body>
</html>
