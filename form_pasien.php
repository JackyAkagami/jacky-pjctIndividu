<?php
// Memulai session untuk mengecek apakah user sudah login
session_start();
// Jika session login belum diset, maka redirect ke halaman login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit; // Menghentikan eksekusi script setelah redirect
}

// Menyisipkan file koneksi database
include 'koneksi.php';
// Mengecek apakah halaman ini diakses melalui form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Menyimpan input dari form ke dalam variabel
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $no_hp = $_POST['no_hp'];
  // Menjalankan perintah SQL untuk menambahkan data pasien ke database
  mysqli_query($conn, "INSERT INTO pasien (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')");
  // Setelah data ditambahkan, redirect kembali ke halaman index
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Judul halaman -->
  <title>Tambah Pasien</title>
  <!-- Menyisipkan file CSS untuk tampilan -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Judul utama halaman -->
  <h2>Tambah Pasien</h2>
  <!-- Form input pasien menggunakan metode POST -->
  <form method="POST">
    <!-- Input field untuk nama pasien -->
    Nama: <input type="text" name="nama"><br>
    <!-- Textarea untuk alamat pasien -->
    Alamat: <textarea name="alamat"></textarea><br>
    <!-- Input field untuk nomor HP -->
    No HP: <input type="text" name="no_hp"><br>
    <!-- Tombol submit -->
    <input type="submit" value="Simpan">
  </form>
</body>
</html>

