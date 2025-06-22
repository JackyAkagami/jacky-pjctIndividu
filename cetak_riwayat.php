<?php
session_start(); // Memulai session untuk mengecek apakah dokter sudah login
// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}

require 'dompdf/autoload.inc.php'; // Memuat autoload Dompdf (library PDF)

// Namespace dari Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

include 'koneksi.php'; // Menyambungkan ke database

$id_dokter = $_SESSION['id_dokter']; // Ambil id dokter dari session
$tanggal = date('Y-m-d'); // Ambil tanggal hari ini dalam format YYYY-MM-DD

// Query data riwayat pemeriksaan yang sudah selesai hari ini, milik dokter yang login
$q_dokter = mysqli_query($conn, "SELECT nama_dokter FROM dokter WHERE id_dokter='$id_dokter'");
$d = mysqli_fetch_assoc($q_dokter);
$dokter = $d['nama_dokter'] ?? 'Tidak diketahui'; // Jika tidak ditemukan, fallback

// Ambil riwayat pemeriksaan hari ini
$q = mysqli_query($conn, "SELECT s.*, p.nama, p.alamat, p.no_hp
                          FROM pemeriksaan_selesai s
                          JOIN pasien p ON s.id_pasien = p.id_pasien
                          WHERE s.id_dokter='$id_dokter' 
                          AND DATE(selesai_pada) = '$tanggal'
                          ORDER BY selesai_pada DESC");


// Buat HTML konten untuk file PDF
$html = "
<h2 style='text-align:center;'>Riwayat Pemeriksaan - Dokter $dokter</h2>
<p style='text-align:center;'>Tanggal: ".date('d/m/Y')."</p>
<table border='1' cellpadding='6' cellspacing='0' width='100%'>
<tr>
  <th>Nama</th>
  <th>Alamat</th>
  <th>No HP</th>
  <th>Tanggal</th>
  <th>Jam</th>
  <th>Keluhan</th>
  <th>Selesai Pada</th>
</tr>";

// Loop setiap baris hasil query, lalu tambahkan ke dalam tabel HTML
while ($r = mysqli_fetch_assoc($q)) {
    $html .= "<tr>
        <td>{$r['nama']}</td>
        <td>{$r['alamat']}</td>
        <td>{$r['no_hp']}</td>
        <td>{$r['tanggal']}</td>
        <td>{$r['jam']}</td>
        <td>{$r['keluhan']}</td>
        <td>{$r['selesai_pada']}</td>
    </tr>"; 
}

$html .= "</table>"; // Akhiri tag tabel

// Konfigurasi dan render Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); // Izinkan akses remote (jika pakai gambar eksternal misalnya)
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html); // Masukkan HTML ke Dompdf
$dompdf->setPaper('A4', 'portrait'); // Ukuran dan orientasi kertas
$dompdf->render(); // Render HTML jadi PDF

// Bersihkan output buffer agar tidak menyebabkan PDF error
ob_end_clean(); // <- baris penting untuk menghindari error PDF rusak
// Hentikan eksekusi setelah menampilkan PDF
$dompdf->stream("riwayat_dokter_{$id_dokter}.pdf", ["Attachment" => false]);
exit; // Bersihkan output buffer agar tidak menyebabkan PDF error
?>
