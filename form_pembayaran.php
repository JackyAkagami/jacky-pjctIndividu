<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Ambil hanya pemeriksaan yang belum dibayar
$pemeriksaan = mysqli_query($conn, "
    SELECT p.id_periksa, pasien.nama AS nama_pasien, dokter.nama_dokter, p.tanggal
    FROM pemeriksaan p
    JOIN pasien ON p.id_pasien = pasien.id_pasien
    JOIN dokter ON p.id_dokter = dokter.id_dokter
    LEFT JOIN pembayaran b ON p.id_periksa = b.id_periksa
    WHERE b.id_periksa IS NULL
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_periksa = $_POST['id_periksa'];
    $total_biaya = $_POST['total_biaya'];
    $metode_bayar = $_POST['metode_bayar'];

    mysqli_query($conn, "INSERT INTO pembayaran (id_periksa, total_biaya, metode_bayar) 
                         VALUES ('$id_periksa', '$total_biaya', '$metode_bayar')");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Form Tambah Pembayaran</h2>
    <form method="POST">
        <label>Pemeriksaan (yang belum dibayar):</label>
        <select name="id_periksa" required>
            <option value="">-- Pilih Pemeriksaan --</option>
            <?php while ($p = mysqli_fetch_array($pemeriksaan)) {
                echo "<option value='{$p['id_periksa']}'>[{$p['id_periksa']}] {$p['nama_pasien']} - {$p['nama_dokter']} - {$p['tanggal']}</option>";
            } ?>
        </select><br>

        <label>Total Biaya:</label>
        <input type="number" name="total_biaya" required><br>

        <label>Metode Bayar:</label>
        <select name="metode_bayar" required>
            <option value="">-- Pilih Metode --</option>
            <option value="Tunai">Tunai</option>
            <option value="Transfer">Transfer</option>
        </select><br>

        <input type="submit" value="Simpan">
    </form>
</div>
</body>
</html>
