<?php

// Memasukkan file class-mahasiswa.php untuk mengakses class Mahasiswa
include '../config/class-mahasiswa.php';
// Membuat objek dari class Mahasiswa
$buku = new Buku();
// Mengambil data mahasiswa dari form input menggunakan metode POST dan menyimpannya dalam array
$dataBuku = [
    'ISBN' => $_POST['isbn'],
    'judul_buku' => $_POST['judul'],
    'tahun' => $_POST['tahun'],
    'penerbit' => $_POST['penerbit'],
    'kategori' => $_POST['kategori'],
    'email' => $_POST['email'],
    'telp' => $_POST['telp']
];
// Memanggil method inputMahasiswa untuk memasukkan data mahasiswa dengan parameter array $dataMahasiswa
$input = $buku->inputBuku($dataBuku);
// Mengecek apakah proses input berhasil atau tidak - true/false
if($input){
    // Jika berhasil, redirect ke halaman data-list.php dengan status inputsuccess
    header("Location: ../data-list.php?status=inputsuccess");
} else {
    // Jika gagal, redirect ke halaman data-input.php dengan status failed
    header("Location: ../data-input.php?status=failed");
}

?>