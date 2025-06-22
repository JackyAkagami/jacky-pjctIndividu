<?php
session_start();// Memulai session PHP agar bisa menggunakan data session yang telah diset saat login
// Mengecek apakah dokter sudah login atau belum
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php"); // Jika belum login, arahkan ke halaman login_dokter.php
    exit; // Hentikan eksekusi kode
}
include 'koneksi.php';  // Menghubungkan ke file koneksi.php untuk akses ke database

// Mengambil ID pemeriksaan dari URL (parameter GET), jika tidak ada gunakan nilai default 0
$id_periksa = $_GET['id'] ?? 0;

// Query ke tabel pemeriksaan untuk mengambil data berdasarkan id_periksa yang dikirim
$q = mysqli_query($conn, "SELECT * FROM pemeriksaan WHERE id_periksa = '$id_periksa'");
$data = mysqli_fetch_assoc($q); // Ambil data hasil query dalam bentuk array asosiatif
 
if ($data) { // Jika data pemeriksaan ditemukan
    // Simpan data ke tabel pemeriksaan_selesai (riwayat), dengan menyimpan juga id_pasien agar bisa dijoin nanti
    mysqli_query($conn, "INSERT INTO pemeriksaan_selesai 
        (id_dokter, id_pasien, tanggal, jam, keluhan, selesai_pada)
        VALUES (
          '{$data['id_dokter']}', 
          '{$data['id_pasien']}', 
          '{$data['tanggal']}', 
          '{$data['jam']}', 
          '{$data['keluhan']}', 
          NOW()
        )"); //ID dokter dari tabel pemeriksaan,
        //ID pasien dari tabel pemeriksaan
        // Tanggal pemeriksaan
        // Jam pemeriksaan
        // Keluhan pasien
        // Waktu saat ini untuk menandai kapan pemeriksaan selesai

    // Hapus data dari tabel pemeriksaan aktif agar tidak tampil lagi di halaman jadwal dokter
    mysqli_query($conn, "DELETE FROM pemeriksaan WHERE id_periksa = '$id_periksa'");
}


// Arahkan kembali ke halaman jadwal dokter setelah proses selesai
header("Location: jadwal_dokter.php");
exit; // Hentikan eksekusi kode
?>
