<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); exit;
}


include 'koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    mysqli_query($conn, "INSERT INTO pasien (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pasien</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Tambah Pasien</h2>
<form method="POST">
    Nama: <input type="text" name="nama"><br>
    Alamat: <textarea name="alamat"></textarea><br>
    No HP: <input type="text" name="no_hp"><br>
    <input type="submit" value="Simpan">
</form>
</body>
</html>
