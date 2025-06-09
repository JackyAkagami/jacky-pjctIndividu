<?php
session_start();
if(!isset($_SESSION['login'])){ header("Location: login.php"); exit; }
include 'koneksi.php';
?>
<!DOCTYPE html><html><head>
<title>Data Pemeriksaan Klinik Sehat Sentosa</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h1>Data Pemeriksaan Klinik Sehat Sentosa</h1>

<a href="form_pasien.php">Tambah Pasien</a>
<a href="form_dokter.php">Informasi Dokter</a>
<a href="form_pemeriksaan.php">Tambah Pemeriksaan</a>
<a href="form_pembayaran.php">Tambah Pembayaran</a>
<a href="logout.php" style="background:#dc3545;">Logout</a>

<table>
<tr>
 <th>ID</th><th>Pasien</th><th>Dokter</th><th>Tanggal</th><th>Jam</th>
 <th>Keluhan</th><th>Total</th><th>Metode</th><th>Aksi</th>
</tr>
<?php
$sql = "SELECT p.id_periksa, pa.id_pasien, pa.nama AS pasien, d.nama_dokter,
                   p.tanggal, p.jam, p.keluhan,
                   b.total_biaya, b.metode_bayar
            FROM pemeriksaan p
            JOIN pasien pa ON p.id_pasien=pa.id_pasien
            JOIN dokter d ON p.id_dokter=d.id_dokter
            LEFT JOIN pembayaran b ON p.id_periksa=b.id_periksa
            ORDER BY p.id_periksa ASC";
$q = mysqli_query($conn,$sql);
while($r=mysqli_fetch_assoc($q)){
 echo "<tr>
        <td>{$r['id_periksa']}</td>
        <td>{$r['pasien']}</td>
        <td>{$r['nama_dokter']}</td>
        <td>{$r['tanggal']}</td>
        <td>{$r['jam']}</td>
        <td>{$r['keluhan']}</td>
        <td>".($r['total_biaya']??'-')."</td>
        <td>".($r['metode_bayar']??'-')."</td>
        <td>
          <a href='edit_pemeriksaan.php?id={$r['id_periksa']}'>Edit</a>
          <a href='delete_pemeriksaan.php?id={$r['id_periksa']}' 
             onclick=\"return confirm('Hapus data?')\">Hapus</a>
        </td>
      </tr>";
}
?>
</table>
</div></body></html>
