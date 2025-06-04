<?php
include 'koneksi.php';
$pemeriksaan = mysqli_query($conn, "
    SELECT pemeriksaan.id_periksa, pasien.nama AS nama_pasien, dokter.nama_dokter 
    FROM pemeriksaan
    JOIN pasien ON pemeriksaan.id_pasien = pasien.id_pasien
    JOIN dokter ON pemeriksaan.id_dokter = dokter.id_dokter
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_periksa = $_POST['id_periksa'];
    $total_biaya = $_POST['total_biaya'];
    $metode_bayar = $_POST['metode_bayar'];
    mysqli_query($conn, "INSERT INTO pembayaran (id_periksa, total_biaya, metode_bayar) 
                         VALUES ('$id_periksa', '$total_biaya', '$metode_bayar')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Tambah Pembayaran</h2>
<form method="POST">
    Pemeriksaan:
    <select name="id_periksa">
        <?php while ($p = mysqli_fetch_array($pemeriksaan)) {
            echo "<option value='{$p['id_periksa']}'>{$p['nama_pasien']} - {$p['nama_dokter']}</option>";
        } ?>
    </select><br>

    Total Biaya: <input type="number" name="total_biaya"><br>
    Metode Bayar:
    <select name="metode_bayar">
        <option value="Tunai">Tunai</option>
        <option value="Transfer">Transfer</option>
    </select><br>
    <input type="submit" value="Simpan">
</form>
</body>
</html>
