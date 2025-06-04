<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Klinik Sehat - Data Pemeriksaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Data Pemeriksaan Pasien Sehat Sentosa</h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="form_pasien.php">Tambah Pasien</a>
        <a href="form_dokter.php">Tambah Dokter</a>
        <a href="form_pemeriksaan.php">Tambah Pemeriksaan</a>
        <a href="form_pembayaran.php">Tambah Pembayaran</a>
    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Tanggal</th>
            <th>Keluhan</th>
            <th>Total Biaya</th>
            <th>Metode Bayar</th>
        </tr>
        <?php
        $sql = "SELECT pemeriksaan.id_periksa, pasien.nama AS nama_pasien, dokter.nama_dokter,
                       tanggal, keluhan, pembayaran.total_biaya, pembayaran.metode_bayar
                FROM pemeriksaan
                JOIN pasien ON pemeriksaan.id_pasien = pasien.id_pasien
                JOIN dokter ON pemeriksaan.id_dokter = dokter.id_dokter
                LEFT JOIN pembayaran ON pemeriksaan.id_periksa = pembayaran.id_periksa";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>
                    <td>{$row['id_periksa']}</td>
                    <td>{$row['nama_pasien']}</td>
                    <td>{$row['nama_dokter']}</td>
                    <td>{$row['tanggal']}</td>
                    <td>{$row['keluhan']}</td>
                    <td>".($row['total_biaya'] ?? '-')."</td>
                    <td>".($row['metode_bayar'] ?? '-')."</td>
                  </tr>";
        }
        ?>
    </table>
    <div class="footer">
        &copy; 2025 Klinik Sehat Sentosa - Sistem Informasi Rawat Jalan
    </div>
</div>
</body>
</html>

