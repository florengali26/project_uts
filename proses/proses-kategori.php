<?php

// Memasukkan file class-master.php untuk mengakses class MasterData
include '../config/class-master.php';
// Membuat objek dari class MasterData
$master = new MasterData();
// Mengecek aksi yang dilakukan berdasarkan parameter GET 'aksi'
if($_GET['aksi'] == 'inputkategori'){
    // Mengambil data kategori dari form input menggunakan metode POST dan menyimpannya dalam array
    $dataKategori = [
        'nama' => $_POST['nama'] // ✅ Perubahan di sini: Mengambil dari name="nama" dan menggunakan key 'nama'
    ];
    // Memanggil method inputKategori untuk memasukkan data kategori dengan parameter array $dataKategori
    $input = $master->inputKategori($dataKategori);
    if($input){
        header("Location: ../master-kategori-list.php?status=inputsuccess");
    } else {
        header("Location: ../master-kategori-input.php?status=failed");
    }
} elseif($_GET['aksi'] == 'updatekategori'){
    // Mengambil data kategori dari form edit menggunakan metode POST dan menyimpannya dalam array
    $dataKategori = [
        'id' => $_POST['id'], // ✅ Mengambil dari name="id" di form
        'nama' => $_POST['kategori_buku'] // ✅ Menggunakan key 'nama' agar sesuai dengan class-master.php
    ];
    // Memanggil method updateKategori untuk mengupdate data kategori dengan parameter array $dataKategori
    $update = $master->updateKategori($dataKategori);
    if($update){
        header("Location: ../master-kategori-list.php?status=editsuccess");
    } else {
        header("Location: ../master-kategori-edit.php?id=".$dataKategori['id']."&status=failed");
    }
} elseif($_GET['aksi'] == 'deletekategori'){
    // Mengambil id kategori dari parameter GET
    $id = $_GET['id'];
    // Memanggil method deleteKategori untuk menghapus data kategori    berdasarkan id
    $delete = $master->deleteKategori($id);
    if($delete){
        header("Location: ../master-kategori-list.php?status=deletesuccess");
    } else {
        header("Location: ../master-kategori-list.php?status=deletefailed");
    }
}

?>