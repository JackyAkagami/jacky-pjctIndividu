<?php
// Memulai sesi untuk menangani login dan session user
session_start();
// Menyisipkan file koneksi ke database
include 'koneksi.php';

// Mengecek apakah tombol login ditekan
if (isset($_POST['login'])) {
    $u = $_POST['username']; // Menyimpan input username dari form ke variabel $u
    $p = md5($_POST['password']); // Menyimpan input password dari form ke variabel $p, lalu mengenkripsinya dengan md5

    // Menjalankan query untuk mencari data admin dengan username dan password yang cocok
    $q = mysqli_query($conn,"SELECT * FROM admin WHERE username='$u' AND password='$p'");
    if (mysqli_num_rows($q)>0){
        $_SESSION['login']=true; // Jika cocok, set session login menjadi true
        header("Location: index.php"); // Redirect ke halaman utama (index.php)
        exit;// Menghentikan eksekusi script setelah redirect
    }
    // Jika username/password salah, tampilkan alert menggunakan JavaScript
    echo "<script>alert('Username / Password salah');</script>";
}
?>
<!<!DOCTYPE html>
<html>
<head>
  <!-- Judul halaman di tab browser -->
  <title>Login Klinik</title>
  <!-- Menyisipkan file CSS eksternal untuk styling -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Container utama tampilan form login -->
  <div class="container">
    <h2>Login Admin Klinik</h2>
    <!-- Form login menggunakan metode POST -->
    <form method="POST">
      <!-- Input field untuk username (wajib diisi) -->
      Username: <input type="text" name="username" required>
      <!-- Input field untuk password (wajib diisi) -->
      Password: <input type="password" name="password" required>
      <!-- Tombol submit dengan name="login" agar bisa dideteksi oleh PHP -->
      <input type="submit" name="login" value="Login">
    </form>
  </div>
</body>
</html>
