<?php 

include_once 'config/class-master.php';
$master = new MasterData();
// Mengambil daftar program studi, provinsi, dan status mahasiswa
$tahunlist = $master->getTahun();
// Mengambil daftar provinsi
$kategoriList = $master->getKategori();
// Menampilkan alert berdasarkan status yang diterima melalui parameter GET
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
								<h3 class="mb-0">Input Buku</h3>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Input Data Buku</li>
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
                                    <form action="proses/proses-input.php" method="POST">
									    <div class="card-body">
                                            <div class="mb-3">
                                                <label for="judul" class="form-label">Judul Buku</label>
                                                <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul Buku" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="isbn" class="form-label">ISBN Buku(International Standard Book Number)</label>
                                                <input type="number" class="form-control" id="isbn" name="isbn" placeholder="Masukkan ISBN Buku" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tahun" class="form-label">Tahun Terbit</label>
                                                <select class="form-select" id="tahun" name="tahun" required>
                                                    <option value="" selected disabled>Pilih Tahun Terbit</option>
                                                    <?php 
                                                    // Iterasi daftar program studi dan menampilkannya sebagai opsi dalam dropdown
                                                    foreach ($tahunlist as $tahun){
                                                        echo '<option value="'.$tahun['id'].'">'.$tahun['nama'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="penerbit" class="form-label">Nama Penerbit</label>
                                                <textarea class="form-control" id="penerbit" name="penerbit" rows="3" placeholder="Masukkan Nama Penerbit" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="kategori" class="form-label">Kategori</label>
                                                <select class="form-select" id="provinsi" name="kategori" required>
                                                    <option value="" selected disabled>Pilih Kategori</option>
                                                    <?php
                                                    // Iterasi daftar provinsi dan menampilkannya sebagai opsi dalam dropdown
                                                    foreach ($kategoriList as $kategori){
                                                        echo '<option value="'.$kategori['id'].'">'.$kategori['nama'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Valid dan Benar" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="telp" class="form-label">Nomor Telepon</label>
                                                <input type="tel" class="form-control" id="telp" name="telp" placeholder="Masukkan Nomor Telpon/HP" pattern="[0-9+\-\s()]{6,20}" required>
                                            </div>
                                        </div>
									    <div class="card-footer">
                                            <button type="button" class="btn btn-danger me-2 float-start" onclick="window.location.href='data-list.php'">Batal</button>
                                            <button type="reset" class="btn btn-secondary me-2 float-start">Reset</button>
                                            <button type="submit" class="btn btn-primary float-end">Submit</button>
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