<?php
session_start(); // Memulai session untuk menyimpan status login
include 'koneksi.php'; // Menghubungkan ke database

// Cek apakah tombol login ditekan
if (isset($_POST['login'])) {
    $user = $_POST['username']; // Ambil input username dari form
    $pass = md5($_POST['password']); // Ambil input password, lalu enkripsi dengan md5

    // Cek apakah username dan password cocok dengan data di tabel akun_dokter
    $q = mysqli_query($conn, "SELECT * FROM akun_dokter WHERE username='$user' AND password='$pass'");
    // Jika ditemukan, simpan status login ke session
    if (mysqli_num_rows($q) > 0) {
        $data = mysqli_fetch_assoc($q);
        $_SESSION['dokter_login'] = true; // Menandai bahwa dokter sudah login
        $_SESSION['id_dokter'] = $data['id_dokter']; // Simpan ID dokter yang login ke session
        header("Location: jadwal_dokter.php");
        exit; // Hentikan eksekusi setelah redirect
    } else {
      // Jika tidak ditemukan, tampilkan peringatan
        echo "<script>alert('Username / Password salah');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Dokter</title>
  <link rel="stylesheet" href="style.css"><!-- Panggil file CSS untuk styling -->
</head>
<body>
<h2>Login Dokter</h2>
<!-- Form login -->
<form method="POST">
  Username: <input type="text" name="username" required><br> <!-- Input username -->
  Password: <input type="password" name="password" required><br></br> <!-- Input password -->
  <input type="submit" name="login" value="Login"> <!-- Tombol login -->
</form>
</body>
</html>
