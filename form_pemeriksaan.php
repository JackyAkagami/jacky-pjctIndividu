<?php
include 'koneksi.php';
$pasien = mysqli_query($conn, "SELECT * FROM pasien");
$dokter = mysqli_query($conn, "SELECT * FROM dokter");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $tanggal = $_POST['tanggal'];
    $keluhan = $_POST['keluhan'];
    mysqli_query($conn, "INSERT INTO pemeriksaan (id_pasien, id_dokter, tanggal, keluhan) 
                         VALUES ('$id_pasien', '$id_dokter', '$tanggal', '$keluhan')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pemeriksaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Tambah Pemeriksaan</h2>
<form method="POST">
    Pasien:
    <select name="id_pasien">
        <?php while ($p = mysqli_fetch_array($pasien)) {
            echo "<option value='{$p['id_pasien']}'>{$p['nama']}</option>";
        } ?>
    </select><br>

    Dokter:
    <select name="id_dokter">
        <?php while ($d = mysqli_fetch_array($dokter)) {
            echo "<option value='{$d['id_dokter']}'>{$d['nama_dokter']}</option>";
        } ?>
    </select><br>

    Tanggal: <input type="date" name="tanggal"><br>
    Keluhan: <textarea name="keluhan"></textarea><br>
    <input type="submit" value="Simpan">
</form>
</body>
</html>
