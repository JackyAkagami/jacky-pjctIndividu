<?php
// Memulai session untuk memastikan user sudah login
session_start();

// Jika session 'login' belum ada, arahkan ke login dan hentikan eksekusi
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

// Menghubungkan ke database
include 'koneksi.php';

// Mengambil data pasien dan dokter dari database untuk dropdown form
$pasien = mysqli_query($conn, "SELECT * FROM pasien");
$dokter = mysqli_query($conn, "SELECT * FROM dokter");

// Jika form dikirim via POST, proses data input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari form
  $id_pasien = $_POST['id_pasien'];
  $id_dokter = $_POST['id_dokter'];
  $tanggal   = $_POST['tanggal'];
  $jam       = $_POST['jam'];
  $keluhan   = $_POST['keluhan'];

  // Cek di database apakah dokter sudah ada jadwal di tanggal dan jam yang sama
  $cek = mysqli_query($conn, "SELECT * FROM pemeriksaan 
    WHERE id_dokter='$id_dokter' AND tanggal='$tanggal' AND jam='$jam'");

  if (mysqli_num_rows($cek) > 0) {
    // Jika jadwal bentrok, ambil nama dokter untuk pesan error
    $dokter_nama = mysqli_fetch_assoc(mysqli_query($conn, 
      "SELECT nama_dokter FROM dokter WHERE id_dokter='$id_dokter'"))['nama_dokter'];

    // Tampilkan alert jadwal bentrok ke user
    echo "<script>alert('Jadwal bentrok! Dokter $dokter_nama sudah punya jadwal pada $tanggal jam $jam');</script>";
  } else {
    // Jika tidak bentrok, simpan data pemeriksaan ke database
    mysqli_query($conn, "INSERT INTO pemeriksaan 
      (id_pasien, id_dokter, tanggal, jam, keluhan) 
      VALUES 
      ('$id_pasien', '$id_dokter', '$tanggal', '$jam', '$keluhan')");

    // Redirect ke halaman utama setelah berhasil simpan
    header("Location: index.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Pemeriksaan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Tambah Pemeriksaan</h2>
  <form method="POST">

    <!-- Dropdown pasien -->
    <label>Pasien:</label>
    <select name="id_pasien" required>
      <?php while ($p = mysqli_fetch_array($pasien)) {
        // Set opsi terpilih jika form di-submit tapi ada error (sticky form)
        $selected = (isset($_POST['id_pasien']) && $_POST['id_pasien'] == $p['id_pasien']) ? 'selected' : '';
        echo "<option value='{$p['id_pasien']}' $selected>{$p['nama']}</option>";
      } ?>
    </select>

    <!-- Textarea keluhan -->
    <label style="display:block; margin-top:15px;">Keluhan:</label>
    <textarea name="keluhan" rows="4"><?= isset($_POST['keluhan']) ? htmlspecialchars($_POST['keluhan']) : '' ?></textarea>

    <!-- Input tanggal -->
    <label>Tanggal:</label>
    <input type="date" name="tanggal" value="<?= isset($_POST['tanggal']) ? $_POST['tanggal'] : '' ?>" required>

    <!-- Input jam -->
    <label>Jam:</label>
    <input type="time" name="jam" value="<?= isset($_POST['jam']) ? $_POST['jam'] : '' ?>" required>

    <!-- Dropdown dokter -->
    <label>Dokter:</label>
    <select name="id_dokter" required>
      <?php while ($d = mysqli_fetch_array($dokter)) {
        $selected = (isset($_POST['id_dokter']) && $_POST['id_dokter'] == $d['id_dokter']) ? 'selected' : '';
        echo "<option value='{$d['id_dokter']}' $selected>{$d['nama_dokter']} - {$d['spesialis']}</option>";
      } ?>
    </select>
    <br><br>
    <!-- Tombol submit -->
    <input type="submit" value="Simpan">
  </form>
</div>
</body>
</html>
