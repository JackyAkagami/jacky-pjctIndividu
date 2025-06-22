<?php
session_start();
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}
include 'koneksi.php';

$id_periksa = $_GET['id'] ?? 0;

// Ambil data pemeriksaan
$q = mysqli_query($conn, "SELECT * FROM pemeriksaan WHERE id_periksa = '$id_periksa'");
$data = mysqli_fetch_assoc($q);

if ($data) {
    // Simpan ke tabel selesai (sekarang pakai id_pasien)
    mysqli_query($conn, "INSERT INTO pemeriksaan_selesai 
        (id_dokter, id_pasien, tanggal, jam, keluhan, selesai_pada)
        VALUES (
          '{$data['id_dokter']}', 
          '{$data['id_pasien']}', 
          '{$data['tanggal']}', 
          '{$data['jam']}', 
          '{$data['keluhan']}', 
          NOW()
        )");

    // Hapus dari tabel aktif
    mysqli_query($conn, "DELETE FROM pemeriksaan WHERE id_periksa = '$id_periksa'");
}

header("Location: jadwal_dokter.php");
exit;
?>
