<?php
session_start();
if (!isset($_SESSION['dokter_login'])) {
    header("Location: login_dokter.php");
    exit;
}
require 'dompdf/autoload.inc.php'; // pastikan path sesuai

use Dompdf\Dompdf;
use Dompdf\Options;

include 'koneksi.php';
$id_dokter = $_SESSION['id_dokter'];

// Ambil nama dokter
$dokter = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_dokter FROM dokter WHERE id_dokter='$id_dokter'"))['nama_dokter'];

$tanggal_hari_ini = date('Y-m-d');

$q = mysqli_query($conn, "SELECT * FROM pemeriksaan_selesai 
                          WHERE id_dokter='$id_dokter' 
                          AND DATE(selesai_pada) = '$tanggal_hari_ini'
                          ORDER BY selesai_pada DESC");


// Buat konten HTML
$html = "
<h2 style='text-align:center;'>Riwayat Pemeriksaan - Dokter $dokter</h2>
<p style='text-align:center;'>Tanggal: ".date('d/m/Y')."</p>
<table border='1' cellpadding='6' cellspacing='0' width='100%'>
<tr>
  <th>Pasien</th><th>Tanggal</th><th>Jam</th><th>Keluhan</th><th>Selesai Pada</th>
</tr>";

while ($r = mysqli_fetch_assoc($q)) {
    $html .= "<tr>
        <td>{$r['nama_pasien']}</td>
        <td>{$r['tanggal']}</td>
        <td>{$r['jam']}</td>
        <td>{$r['keluhan']}</td>
        <td>{$r['selesai_pada']}</td>
    </tr>";
}
$html .= "</table>";

// Inisialisasi dan render PDF
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("riwayat_{$dokter}.pdf", ["Attachment" => false]); // tampilkan di browser
?>
