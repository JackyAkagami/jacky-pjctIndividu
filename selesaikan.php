<?php
session_start();
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}
include 'koneksi.php';

$id_periksa = $_GET['id'] ?? 0;
echo "ID DITERIMA: $id_periksa";


// Ambil data pemeriksaan
$q = mysqli_query($conn, "SELECT p.*, pa.nama AS nama_pasien 
                          FROM pemeriksaan p 
                          JOIN pasien pa ON p.id_pasien = pa.id_pasien 
                          WHERE p.id_periksa = '$id_periksa'");

$data = mysqli_fetch_assoc($q);

if ($data) {
    // Simpan ke tabel selesai
    mysqli_query($conn, "INSERT INTO pemeriksaan_selesai 
        (id_dokter, nama_pasien, tanggal, jam, keluhan, selesai_pada)
        VALUES (
          '{$data['id_dokter']}', 
          '{$data['nama_pasien']}', 
          '{$data['tanggal']}', 
          '{$data['jam']}', 
          '{$data['keluhan']}', 
          NOW()
        )");

    // Hapus dari tabel pemeriksaan aktif
    mysqli_query($conn, "DELETE FROM pemeriksaan WHERE id_periksa = '$id_periksa'");
}

// Kembali ke jadwal
header("Location: jadwal_dokter.php");
exit;
?>
