<?php

include_once 'config/class-mahasiswa.php';
$buku = new buku();
// Menampilkan alert berdasarkan status yang diterima melalui parameter GET
$dataBuku = $buku->getAllBuku();

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
								<h3 class="mb-0">Daftar Buku</h3>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Beranda</li>
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
										<h3 class="card-title">Tabel Buku</h3>
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
									<div class="card-body p-0 table-responsive">
										<table class="table table-striped" role="table">
											<thead>
												<tr>
													<th>No</th>
													<th>Judul</th>
													<th>ISBN</th>
													<th>Tahun</th>
													<th>Penerbit</th>
													<th>Kategori</th>
													<th>Email</th>
													<th>Telp</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if(count($dataBuku) == 0){
													    echo '<tr class="align-middle">
															<td colspan="10" class="text-center">Tidak ada data Buku.</td>
														</tr>';
													} else {
														foreach ($dataBuku as $index => $buku){
															echo '<tr class="align-middle">
																<td>'.($index + 1).'</td>
																<td>'.$buku['judul_buku'].'</td>
																<td>'.$buku['ISBN'].'</td>
																<td>'.$buku['tahun'].'</td>
																<td>'.$buku['penerbit'].'</td>
																<td>'.$buku['kategori'].'</td>
																<td>'.$buku['email'].'</td>
																<td>'.$buku['telp'].'</td>
																<td class="text-center">
																	<button type="button" class="btn btn-sm btn-warning me-1" onclick="window.location.href=\'data-edit.php?id='.$buku['id_buku'].'\'"><i class="bi bi-pencil-fill"></i> Edit</button>
																	<button type="button" class="btn btn-sm btn-danger" onclick="if(confirm(\'Yakin ingin menghapus data buku ini?\')){window.location.href=\'proses/proses-delete.php?id='.$buku['id_buku'].'\'}"><i class="bi bi-trash-fill"></i> Hapus</button>
																</td>
															</tr>';
														}
													}
												?>
											</tbody>
										</table>
									</div>
									<div class="card-footer">
										<button type="button" class="btn btn-primary" onclick="window.location.href='data-input.php'"><i class="bi bi-plus-lg"></i> Tambah Buku</button>
									</div>
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