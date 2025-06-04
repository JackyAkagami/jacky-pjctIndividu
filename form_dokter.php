<?php
include 'koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_dokter = $_POST['nama_dokter'];
    $spesialis = $_POST['spesialis'];
    mysqli_query($conn, "INSERT INTO dokter (nama_dokter, spesialis) VALUES ('$nama_dokter', '$spesialis')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Dokter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Tambah Dokter</h2>
<form method="POST">
    Nama Dokter: <input type="text" name="nama_dokter"><br>
    Spesialis: <input type="text" name="spesialis"><br>
    <input type="submit" value="Simpan">
</form>
</body>
</html>
