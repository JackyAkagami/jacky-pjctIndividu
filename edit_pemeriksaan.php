<?php
session_start(); 
// Memulai session agar bisa akses data session
if(!isset($_SESSION['login'])){
    // Jika session login belum ada, artinya belum login
    header("Location: login.php"); // arahkan ke halaman login
    exit; // hentikan eksekusi script
}
include 'koneksi.php'; 
// Hubungkan file ini ke file koneksi.php untuk koneksi database
$id = $_GET['id']; 
// Ambil nilai 'id' dari URL, yaitu id pemeriksaan yang ingin diedit
// Ambil data pemeriksaan berdasarkan id tersebut untuk ditampilkan di form
$det = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemeriksaan WHERE id_periksa='$id'"));
// Ambil data semua pasien dan dokter untuk opsi pilihan di form (pasien hanya ditampilkan nama, dokter dalam select option)
$pasien = mysqli_query($conn, "SELECT * FROM pasien");
$dokter = mysqli_query($conn, "SELECT * FROM dokter");
// Jika form dikirim (method POST), proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_dokter = $_POST['id_dokter']; // ambil id dokter yang dipilih
    $tanggal   = $_POST['tanggal'];   // ambil tanggal
    $jam       = $_POST['jam'];       // ambil jam
    $keluhan   = $_POST['keluhan'];   // ambil keluhan
    // Cek apakah jadwal dokter sudah bentrok dengan jadwal lain di hari dan jam yang sama,
    // tapi kecuali data pemeriksaan yang sedang diedit (id_periksa != $id)
    $bentrok = mysqli_query($conn, "SELECT * FROM pemeriksaan
        WHERE id_dokter='$id_dokter' AND tanggal='$tanggal' 
          AND jam='$jam' AND id_periksa != '$id'");
    if (mysqli_num_rows($bentrok) > 0) {
        // Jika jadwal bentrok, tampilkan alert di browser
        echo "<script>alert('Jadwal bentrok!');</script>";
    } else {
        // Jika tidak bentrok, update data pemeriksaan sesuai inputan
        mysqli_query($conn, "UPDATE pemeriksaan SET
            id_dokter='$id_dokter', tanggal='$tanggal', jam='$jam', keluhan='$keluhan'
            WHERE id_periksa='$id'");
        // Setelah update, redirect ke halaman index.php
        header("Location: index.php"); 
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Edit Pemeriksaan</h2>
<form method="POST">
    Pasien: <b>
    <?php 
    // Ambil nama pasien dari database berdasarkan id_pasien di data pemeriksaan yang diambil
    $ps = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM pasien WHERE id_pasien='{$det['id_pasien']}'"));
    echo $ps['nama']; 
    ?>
    </b><br><br>

    Dokter:
    <select name="id_dokter">
    <?php 
    // Loop data dokter, dan set opsi yang dipilih sesuai data pemeriksaan
    while ($d = mysqli_fetch_assoc($dokter)) {
        $s = $d['id_dokter'] == $det['id_dokter'] ? 'selected' : '';
        echo "<option $s value='{$d['id_dokter']}'>{$d['nama_dokter']}</option>";
    }
    ?>
    </select>

    Tanggal:<input type="date" name="tanggal" value="<?=$det['tanggal'];?>" required>
    Jam:<input type="time" name="jam" value="<?=$det['jam'];?>" required>
    Keluhan:<textarea name="keluhan"><?=$det['keluhan'];?></textarea>
    <input type="submit" value="Update">
</form>
</div>
</body>
</html>
