<?php 

include_once 'config/class-master.php';
include_once 'config/class-mahasiswa.php';
$master = new MasterData();
$buku = new Buku();
// Mengambil daftar program studi, provinsi, dan status mahasiswa
$tahunList = $master->getTahun();
// Mengambil daftar provinsi
$kategoriList = $master->getKategori();
// Mengambil daftar status mahasiswa
$statusList = $master->getStatus();
// Mengambil data mahasiswa yang akan diedit berdasarkan id dari parameter GET
$dataBuku = $buku->getUpdateBuku($_GET['id']);
if(isset($_GET['status'])){
    if($_GET['status'] == 'failed'){
        echo "<script>alert('Gagal mengubah data buku. Silakan coba lagi.');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include 'template/header.php'; ?>
	</head>

	<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

		<div class="app-wrapper">

			<?php include 'template/navbar.php'; ?>

			<?php include 'template/sidebar.php'; ?>

			<main class="app-main">

				<div class="app-content-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<h3 class="mb-0">Edit Buku</h3>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit Data</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Formulir Buku</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
												<i data-lte-icon="expand" class="bi bi-plus-lg"></i>
												<i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
											</button>
											<button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove">
												<i class="bi bi-x-lg"></i>
											</button>
										</div>
									</div>
                                    <form action="proses/proses-edit.php" method="POST">
									    <div class="card-body">
                                            <input type="hidden" name="id" value="<?php echo $dataBuku['id']; ?>">
                                            <div class="mb-3">
                                                <label for="judul" class="form-label">Judul Buku</label>
                                                <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul Buku" value="<?php echo $dataBuku['judul']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="isbn" class="form-label">ISBN Buku (International Standard Book Number)</label>
                                                <input type="number" class="form-control" id="isbn" name="isbn" placeholder="Masukkan ISBN Buku" value="<?php echo $dataBuku['isbn']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tahun" class="form-label">Tahun Terbit</label>
                                                <select class="form-select" id="tahun" name="tahun" required>
                                                    <option value="" selected disabled>Pilih Tahun Terbit</option>
                                                    <?php 
                                                    // Iterasi daftar program studi dan menandai yang sesuai dengan data mahasiswa yang dipilih
                                                    foreach ($tahunList as $tahun){
                                                        // Menginisialisasi variabel kosong untuk menandai opsi yang dipilih
                                                        $selectedTahun = "";
                                                        // Mengecek apakah program studi saat ini sesuai dengan data mahasiswa
                                                        if($dataBuku['tahun'] == $tahun['id']){
                                                            // Jika sesuai, tandai sebagai opsi yang dipilih
                                                            $selectedTahun = "selected";
                                                        }
                                                        // Menampilkan opsi program studi dengan penanda yang sesuai
                                                        echo '<option value="'.$tahun['id'].'" '.$selectedTahun.'>'.$tahun['nama'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="penerbit" class="form-label">Nama Penerbit</label>
                                                <textarea class="form-control" id="penerbit" name="penerbit" rows="3" placeholder="Masukkan Nama Penerbit" required><?php echo $dataBuku['penerbit']; ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="kategori" class="form-label">Kategori</label>
                                                <select class="form-select" id="kategori" name="kategori" required>
                                                    <option value="" selected disabled>Pilih Kategori</option>
                                                    <?php
                                                    // Iterasi daftar provinsi dan menandai yang sesuai dengan data mahasiswa yang dipilih
                                                    foreach ($kategoriList as $kategori){
                                                        // Menginisialisasi variabel kosong untuk menandai opsi yang dipilih
                                                        $selectedkategori = "";
                                                        // Mengecek apakah provinsi saat ini sesuai dengan data mahasiswa
                                                        if($dataBuku['kategori'] == $kategori['id']){
                                                            // Jika sesuai, tandai sebagai opsi yang dipilih
                                                            $selectedkategori = "selected";
                                                        }
                                                        // Menampilkan opsi kategori dengan penanda yang sesuai
                                                        echo '<option value="'.$kategori['id'].'" '.$selectedkategori.'>'.$kategori['nama'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Valid dan Benar" value="<?php echo $dataBuku['email']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="telp" class="form-label">Nomor Telepon</label>
                                                <input type="tel" class="form-control" id="telp" name="telp" placeholder="Masukkan Nomor Telpon/HP" value="<?php echo $dataBuku['telp']; ?>" pattern="[0-9+\-\s()]{6,20}" required>
                                            </div>                                           
                                        </div>
									    <div class="card-footer">
                                            <button type="button" class="btn btn-danger me-2 float-start" onclick="window.location.href='data-list.php'">Batal</button>
                                            <button type="submit" class="btn btn-warning float-end">Update Data</button>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>

			</main>

			<?php include 'template/footer.php'; ?>

		</div>
		
		<?php include 'template/script.php'; ?>

	</body>
</html>