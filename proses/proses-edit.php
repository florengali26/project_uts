<?php

// Memasukkan file class-mahasiswa.php untuk mengakses class Mahasiswa
include_once '../config/class-mahasiswa.php';
// Membuat objek dari class Mahasiswa
$buku = new Buku();
// Mengambil data mahasiswa dari form edit menggunakan metode POST dan menyimpannya dalam array
$dataBuku = [
    'id_buku' => $row['id_buku'],
    'ISBN' => $row['ISBN'],
    'judul' => $row['judul_buku'],
    'tahun' => $row['tahun'],
    'kategori' => $row['kategori'],
    'alamat' => $row['alamat'],
    'email' => $row['email'],
    'telp' => $row['telp'],
];
// Memanggil method editMahasiswa untuk mengupdate data mahasiswa dengan parameter array $dataMahasiswa
$edit = $buku->editBuku($dataBuku);
// Mengecek apakah proses edit berhasil atau tidak - true/false
if($edit){
    // Jika berhasil, redirect ke halaman data-list.php dengan status editsuccess
    header("Location: ../data-list.php?status=editsuccess");
} else {
    // Jika gagal, redirect ke halaman data-edit.php dengan status failed dan membawa id mahasiswa
    header("Location: ../data-edit.php?id=".$dataBuku['id']."&status=failed");
}

?>