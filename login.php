<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = md5($_POST['password']);

    $q = mysqli_query($conn,"SELECT * FROM admin WHERE username='$u' AND password='$p'");
    if (mysqli_num_rows($q)>0){
        $_SESSION['login']=true;
        header("Location: index.php"); exit;
    }
    echo "<script>alert('Username / Password salah');</script>";
}
?>
<!DOCTYPE html><html><head>
<title>Login Klinik</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
  <h2>Login Admin Klinik</h2>
  <form method="POST">
    Username: <input type="text" name="username" required>
    Password: <input type="password" name="password" required>
    <input type="submit" name="login" value="Login">
  </form>
</div></body></html>
