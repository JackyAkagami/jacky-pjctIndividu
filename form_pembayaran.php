<?php
// Menghubungkan ke database
include 'koneksi.php';

// Ambil data pemeriksaan beserta nama pasien dan dokter untuk dropdown
$pemeriksaan = mysqli_query($conn, "
    SELECT p.id_periksa, pasien.nama AS nama_pasien, dokter.nama_dokter, p.tanggal
    FROM pemeriksaan p
    JOIN pasien ON p.id_pasien = pasien.id_pasien
    JOIN dokter ON p.id_dokter = dokter.id_dokter
    LEFT JOIN pembayaran b ON p.id_periksa = b.id_periksa
    WHERE b.id_periksa IS NULL
");
// Ambil ID pemeriksaan, nama pasien, nama dokter, dan tanggal pemeriksaan
// Tabel utama adalah pemeriksaan, diberi alias p
// Gabungkan tabel pasien berdasarkan id_pasien
// Gabungkan tabel pasien berdasarkan id_pasien
// Gabungkan (left join) dengan tabel pembayaran berdasarkan id_periksa, agar data pemeriksaan tetap ditampilkan meskipun belum ada pembayaran
// Hanya ambil data pemeriksaan yang belum memiliki pembayaran (belum dibayar)


// Jika form dikirim dengan metode POST (form disubmit)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari form
  $id_periksa = $_POST['id_periksa'];
  $total_biaya = $_POST['total_biaya'];
  $metode_bayar = $_POST['metode_bayar'];

  // Simpan data pembayaran ke tabel pembayaran
  mysqli_query($conn, "INSERT INTO pembayaran (id_periksa, total_biaya, metode_bayar) 
            VALUES ('$id_periksa', '$total_biaya', '$metode_bayar')");

  // Setelah simpan, arahkan ke halaman index.php
  header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2> Tambah Pembayaran</h2>
    <form method="POST">
    <!-- Dropdown pilihan pemeriksaan yang menampilkan nama pasien dan nama dokter -->
        <label>Pemeriksaan (yang belum dibayar):</label>
        <select name="id_periksa" required>
            <option value="">-- Pilih Pemeriksaan --</option>
            <?php while ($p = mysqli_fetch_array($pemeriksaan)) {
                echo "<option value='{$p['id_periksa']}'>[{$p['id_periksa']}] {$p['nama_pasien']} - {$p['nama_dokter']} - {$p['tanggal']}</option>";
            } ?>
        </select><br>

        <!-- Input jumlah total biaya -->
        <label>Total Biaya:</label>
        <input type="number" name="total_biaya" required><br>

        <!-- Dropdown metode pembayaran -->
        <label>Metode Bayar:</label>
        <select name="metode_bayar" required>
            <option value="">-- Pilih Metode --</option>
            <option value="Tunai">Tunai</option>
            <option value="Transfer">Transfer</option>
        </select><br>

        <!-- Tombol submit -->
        <input type="submit" value="Simpan">
    </form>
</div>
</body>
</html>
