<?php
session_start(); // Memulai session untuk mengecek login
if(!isset($_SESSION['login'])){ 
    header("Location: login.php"); // Jika belum login, arahkan ke halaman login
    exit; 
}
// Jika user belum login (session 'login' tidak ada), redirect ke halaman login dan hentikan script

include 'koneksi.php'; // Memasukkan file koneksi.php yang berisi kode koneksi ke database
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Pemeriksaan Klinik Sehat Sentosa</title>
    <link rel="stylesheet" href="style.css"> <!-- Memanggil file CSS -->
</head>
<body>
<div class="container">
<h1>Data Pemeriksaan Klinik Sehat Sentosa</h1>

<!-- Navigasi / tombol untuk menuju form lain -->
<a href="form_pasien.php">Tambah Pasien</a>
<a href="form_dokter.php">Informasi Dokter</a>
<a href="form_pemeriksaan.php">Tambah Pemeriksaan</a>
<a href="form_pembayaran.php">Tambah Pembayaran</a>
<a href="logout.php" style="background:#dc3545;">Logout</a>

<!-- Form pencarian pasien berdasarkan nama -->
<form method="GET" style="margin: 20px 0;">
    <input type="text" name="cari" placeholder="Cari nama pasien..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
    <input type="submit" value="Cari">
    <a href="index.php">Reset</a>
</form>

<!-- Tabel untuk menampilkan data pemeriksaan -->
<table>
<tr>
  <th>ID</th><th>Pasien</th><th>Dokter</th><th>Tanggal</th><th>Jam</th>
  <th>Keluhan</th><th>Total</th><th>Metode</th><th>Aksi</th>
</tr>
<?php
// Ambil nilai pencarian jika ada
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';

// Query untuk mengambil data pemeriksaan lengkap dengan data pasien, dokter, dan pembayaran
$sql = "SELECT p.id_periksa, pa.id_pasien, pa.nama AS pasien, d.nama_dokter,
               p.tanggal, p.jam, p.keluhan,
               b.total_biaya, b.metode_bayar
        FROM pemeriksaan p
        JOIN pasien pa ON p.id_pasien=pa.id_pasien
        JOIN dokter d ON p.id_dokter=d.id_dokter
        LEFT JOIN pembayaran b ON p.id_periksa=b.id_periksa";

// Jika pengguna mengisi kolom pencarian, tambahkan kondisi WHERE
if ($cari != '') {
    $sql .= " WHERE pa.nama LIKE '%$cari%'";
}

// Tambahkan urutan data berdasarkan ID pemeriksaan
$sql .= " ORDER BY p.id_periksa ASC"; 

// Jalankan query di database
$q = mysqli_query($conn,$sql);

// Tampilkan hasil query ke dalam tabel HTML
while($r=mysqli_fetch_assoc($q)){ // Loop setiap baris hasil query untuk ditampilkan di tabel
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
          // Tampilkan data setiap pemeriksaan ke dalam baris tabel,
          // Kolom aksi berisi link untuk edit dan hapus data,
          // dengan konfirmasi popup saat klik hapus
}
?>
</table>
</div>
</body>
</html>
