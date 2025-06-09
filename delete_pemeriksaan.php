<?php
session_start(); if(!isset($_SESSION['login'])){header("Location: login.php"); exit;}
include 'koneksi.php';
$id = $_GET['id'];
// Hapus pembayaran berdasarkan pemeriksaan pasien
mysqli_query($conn, "DELETE FROM pembayaran WHERE id_periksa IN (SELECT id_periksa FROM pemeriksaan WHERE id_pasien = '$id')");
// Hapus semua pemeriksaan pasien
mysqli_query($conn, "DELETE FROM pemeriksaan WHERE id_pasien = '$id'");
// Hapus data pasien
mysqli_query($conn, "DELETE FROM pasien WHERE id_pasien = '$id'");
header("Location: index.php");
?>
