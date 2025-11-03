<?php

// Memasukkan file class-master.php untuk mengakses class MasterData
include '../config/class-master.php';
// Membuat objek dari class MasterData
$master = new MasterData();
// Mengecek aksi yang dilakukan berdasarkan parameter GET 'aksi'
if($_GET['aksi'] == 'inputtahun'){
    // Mengambil data prodi dari form input menggunakan metode POST dan menyimpannya dalam array
    $dataTahun = [
        'kode' => $_POST['kode'],
        'nama' => $_POST['nama']
    ];
    // Memanggil method inputProdi untuk memasukkan data prodi dengan parameter array $dataProdi
    $input = $master->inputTahun($dataTahun);
    if($input){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status inputsuccess
        header("Location: ../master-tahun-list.php?status=inputsuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-input.php dengan status failed
        header("Location: ../master-tahun-input.php?status=failed");
    }
} elseif($_GET['aksi'] == 'updatetahun'){
    // Mengambil data prodi dari form edit menggunakan metode POST dan menyimpannya dalam array
    $dataTahun = [
        'id' => $_POST['id'],
        'kode' => $_POST['kode'],
        'nama' => $_POST['nama']
    ];
    // Memanggil method updateProdi untuk mengupdate data prodi dengan parameter array $dataProdi
    $update = $master->updateTahun($dataTahun);
    if($update){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status editsuccess
        header("Location: ../master-tahun-list.php?status=editsuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-edit.php dengan status failed dan membawa id prodi
        header("Location: ../master-tahun-edit.php?id=".$dataTahun['id']."&status=failed");
    }
} elseif($_GET['aksi'] == 'deletetahun'){
    // Mengambil id prodi dari parameter GET
    $id = $_GET['id'];
    // Memanggil method deleteProdi untuk menghapus data prodi berdasarkan id
    $delete = $master->deleteTahun($id);
    if($delete){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status deletesuccess
        header("Location: ../master-tahun-list.php?status=deletesuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-list.php dengan status deletefailed
        header("Location: ../master-tahun-list.php?status=deletefailed");
    }
}

?>