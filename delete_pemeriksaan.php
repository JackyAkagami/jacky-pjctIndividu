<?php
session_start(); if(!isset($_SESSION['login'])){header("Location: login.php"); exit;}
include 'koneksi.php';
$id=$_GET['id'];
mysqli_query($conn,"DELETE FROM pemeriksaan WHERE id_periksa='$id'");
mysqli_query($conn,"DELETE FROM pembayaran   WHERE id_periksa='$id'");
header("Location: index.php");
?>
