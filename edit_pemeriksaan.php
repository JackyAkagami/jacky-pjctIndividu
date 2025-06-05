<?php
session_start(); if(!isset($_SESSION['login'])){header("Location: login.php"); exit;}
include 'koneksi.php';

$id=$_GET['id'];
$det=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM pemeriksaan WHERE id_periksa='$id'"));
$pasien=mysqli_query($conn,"SELECT * FROM pasien");
$dokter=mysqli_query($conn,"SELECT * FROM dokter");

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $id_dokter=$_POST['id_dokter'];
  $tanggal  =$_POST['tanggal'];
  $jam      =$_POST['jam'];
  $keluhan  =$_POST['keluhan'];

  $bentrok=mysqli_query($conn,"SELECT * FROM pemeriksaan
          WHERE id_dokter='$id_dokter' AND tanggal='$tanggal'
            AND jam='$jam' AND id_periksa!='$id'");
  if(mysqli_num_rows($bentrok)>0){
      echo"<script>alert('Jadwal bentrok!');</script>";
  }else{
      mysqli_query($conn,"UPDATE pemeriksaan SET
            id_dokter='$id_dokter', tanggal='$tanggal', jam='$jam', keluhan='$keluhan'
            WHERE id_periksa='$id'");
      header("Location: index.php"); exit;
  }
}
?>
<!DOCTYPE html><html><head><title>Edit</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Edit Pemeriksaan</h2>
<form method="POST">
Pasien: <b><?php
$ps=mysqli_fetch_assoc(mysqli_query($conn,"SELECT nama FROM pasien WHERE id_pasien='{$det['id_pasien']}'"));
echo $ps['nama'];?></b><br><br>

Dokter:
<select name="id_dokter">
<?php while($d=mysqli_fetch_assoc($dokter)){
$s=$d['id_dokter']==$det['id_dokter']?'selected':'';
echo"<option $s value='{$d['id_dokter']}'>{$d['nama_dokter']}</option>";}?>
</select>

Tanggal:<input type="date" name="tanggal" value="<?=$det['tanggal'];?>" required>
Jam:<input type="time" name="jam" value="<?=$det['jam'];?>" required>
Keluhan:<textarea name="keluhan"><?=$det['keluhan'];?></textarea>
<input type="submit" value="Update">
</form></div></body></html>
