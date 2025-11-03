<?php

// Memasukkan file class-mahasiswa.php untuk mengakses class Buku
include_once '../config/class-mahasiswa.php';
// Membuat objek dari class Buku
$buku = new Buku();
// Mengambil id Buku dari parameter GET
$id = $_GET['id'];
// Memanggil method deleteBuku untuk menghapus data Buku berdasarkan id
$delete = $buku->deleteBuku($id);
// Mengecek apakah proses delete berhasil atau tidak - true/false
if($delete){
    // Jika berhasil, redirect ke halaman data-list.php dengan status deletesuccess
    header("Location: ../data-list.php?status=deletesuccess");
} else {
    // Jika gagal, redirect ke halaman data-list.php dengan status deletefailed
    header("Location: ../data-list.php?status=deletefailed");
}

?>