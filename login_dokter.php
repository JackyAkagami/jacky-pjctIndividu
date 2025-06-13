<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $q = mysqli_query($conn, "SELECT * FROM akun_dokter WHERE username='$user' AND password='$pass'");
    if (mysqli_num_rows($q) > 0) {
        $data = mysqli_fetch_assoc($q);
        $_SESSION['dokter_login'] = true;
        $_SESSION['id_dokter'] = $data['id_dokter'];
        header("Location: jadwal_dokter.php");
        exit;
    } else {
        echo "<script>alert('Username / Password salah');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Dokter</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Login Dokter</h2>
<form method="POST">
  Username: <input type="text" name="username" required><br>
  Password: <input type="password" name="password" required><br></br>
  <input type="submit" name="login" value="Login">
</form>
</body>
</html>
