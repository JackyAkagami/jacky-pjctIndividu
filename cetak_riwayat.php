<?php
session_start();
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}

require 'dompdf/autoload.inc.php'; // pastikan path-nya sesuai

use Dompdf\Dompdf;
use Dompdf\Options;

include 'koneksi.php';

$id_dokter = $_SESSION['id_dokter'];
$tanggal = date('Y-m-d');

// Ambil nama dokter
$q_dokter = mysqli_query($conn, "SELECT nama_dokter FROM dokter WHERE id_dokter='$id_dokter'");
$d = mysqli_fetch_assoc($q_dokter);
$dokter = $d['nama_dokter'] ?? 'Tidak diketahui';

// Ambil riwayat pemeriksaan hari ini
$q = mysqli_query($conn, "SELECT s.*, p.nama, p.alamat, p.no_hp
                          FROM pemeriksaan_selesai s
                          JOIN pasien p ON s.id_pasien = p.id_pasien
                          WHERE s.id_dokter='$id_dokter' 
                          AND DATE(selesai_pada) = '$tanggal'
                          ORDER BY selesai_pada DESC");


// HTML konten untuk PDF
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

$html .= "</table>";

// Inisialisasi Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// BERSIHKAN output buffer sebelum stream
ob_end_clean(); // <- baris penting untuk menghindari error PDF rusak
$dompdf->stream("riwayat_dokter_{$id_dokter}.pdf", ["Attachment" => false]);
exit;
?>
