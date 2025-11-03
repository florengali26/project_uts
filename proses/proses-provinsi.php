<?php

// Memasukkan file class-master.php untuk mengakses class MasterData
include '../config/class-master.php';
// Membuat objek dari class MasterData
$master = new MasterData();
// Mengecek aksi yang dilakukan berdasarkan parameter GET 'aksi'
if($_GET['aksi'] == 'inputkategori'){
    // Mengambil data provinsi dari form input menggunakan metode POST dan menyimpannya dalam array
    $dataKategori = [
        'kategori' => $_POST['kategori_buku']
    ];
    // Memanggil method inputProvinsi untuk memasukkan data provinsi dengan parameter array $dataProvinsi
    $input = $master->inputKategori($dataKategori);
    if($input){
        header("Location: ../master-kategori-list.php?status=inputsuccess");
    } else {
        header("Location: ../master-kategori-input.php?status=failed");
    }
} elseif($_GET['aksi'] == 'updatekategori'){
    // Mengambil data provinsi dari form edit menggunakan metode POST dan menyimpannya dalam array
    $dataKategori = [
        'id' => $_POST['id_kategori'],
        'kategori' => $_POST['kategori_buku']
    ];
    // Memanggil method updateProvinsi untuk mengupdate data provinsi dengan parameter array $dataProvinsi
    $update = $master->updateKategori($dataKategori);
    if($update){
        header("Location: ../master-kategori-list.php?status=editsuccess");
    } else {
        header("Location: ../master-kategori-edit.php?id=".$dataKategori['id']."&status=failed");
    }
} elseif($_GET['aksi'] == 'deletekategori'){
    // Mengambil id provinsi dari parameter GET
    $id = $_GET['id'];
    // Memanggil method deleteProvinsi untuk menghapus data provinsi berdasarkan id
    $delete = $master->deleteKategori($id);
    if($delete){
        header("Location: ../master-kategori-list.php?status=deletesuccess");
    } else {
        header("Location: ../master-kategori-list.php?status=deletefailed");
    }
}

?>