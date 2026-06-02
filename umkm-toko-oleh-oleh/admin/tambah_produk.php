<?php
include('../config/koneksi.php');
include('components/header.php');
include('components/sidebar.php');

// Mengambil data kategori untuk dropdown
$query_kat = "SELECT * FROM categories ORDER BY nama_kategori ASC";
$result_kat = mysqli_query($conn, $query_kat);
?>

<div class="layout-page">
	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">
		<div class="container-xxl flex-grow-1 container-p-y">
			<h4 class="fw-bold py-3 mb-4">
				<span class="text-muted fw-light">Manajemen Toko /</span> Tambah Produk
			</h4>

			<?php if (isset($_SESSION['pesan'])) : ?>
				<div class="alert alert-<?= $_SESSION['tipe']; ?> alert-dismissible" role="alert">
					<h6 class="alert-heading d-flex align-items-center fw-bold mb-1">
						<i class="bx <?= $_SESSION['tipe'] == 'success' ? 'bx-check-circle' : 'bx-error-circle'; ?> me-2"></i>
						Notifikasi Sistem
					</h6>
					<span><?= $_SESSION['pesan']; ?></span>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php
				unset($_SESSION['pesan']);
				unset($_SESSION['tipe']);
				?>
			<?php endif; ?>
			<div class="row">
				<div class="col-xl">
					<div class="card mb-4">
						<div class="card-header d-flex justify-content-between align-items-center">
							<h5 class="mb-0">Formulir Produk Baru</h5>
							<small class="text-muted float-end">UMKM Mojokerto</small>
						</div>
						<div class="card-body">
							<form action="action/action_tambah_produk.php" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-8">
										<div class="mb-3">
											<label class="form-label" for="nama_produk">Nama Produk</label>
											<input type="text" name="nama_produk" class="form-control" id="nama_produk" placeholder="Contoh: Onde-onde Original Trowulan" required />
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<label class="form-label">Kategori Produk</label>

												<input type="hidden" name="id_category" id="id_category_hidden" required>

												<div class="dropdown">
													<button class="btn btn-outline-primary dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
														type="button"
														id="btnKategoriDropdown"
														data-bs-toggle="dropdown"
														aria-expanded="false">
														<span id="teksKategoriTerpilih">-- Pilih Kategori --</span>
													</button>

													<ul class="dropdown-menu w-100" aria-labelledby="btnKategoriDropdown">
														<?php
														while ($kat = mysqli_fetch_array($result_kat)) {
														?>
															<li>
																<a class="dropdown-item item-kategori"
																	href="javascript:void(0);"
																	data-id="<?= $kat['id_category']; ?>">
																	<?= $kat['nama_kategori']; ?>
																</a>
															</li>
														<?php } ?>
													</ul>
												</div>
											</div>
											<div class="col-md-6 mb-3">
												<label class="form-label" for="stok">Stok Awal</label>
												<input type="number" name="stok" id="stok" class="form-control" placeholder="0" min="1" required />
											</div>
										</div>

										<div class="mb-3">
											<label class="form-label" for="harga">Harga Jual</label>
											<div class="input-group input-group-merge">
												<span class="input-group-text">Rp</span>
												<input type="number" name="harga" id="harga" class="form-control" placeholder="0" required />
												<span class="input-group-text">.00</span>
											</div>
										</div>

										<div class="mb-3">
											<label class="form-label" for="deskripsi">Deskripsi Produk</label>
											<textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Jelaskan detail keunggulan produk ini..." rows="4"></textarea>
										</div>
									</div>

									<div class="col-md-4 border-start">
										<div class="mb-3">
											<label class="form-label">Foto Produk</label>
											<div class="d-flex align-items-start align-items-sm-center gap-4 mb-3">
												<img src="../assets/img/illustrations/page-misc-error-light.png" alt="preview" class="d-block rounded" height="150" width="150" id="uploadedAvatar" style="object-fit: cover;" />
											</div>
											<div class="button-wrapper">
												<label for="upload" class="btn btn-outline-primary me-2 mb-2" tabindex="0">
													<span class="d-none d-sm-block">Pilih Foto</span>
													<i class="bx bx-upload d-block d-sm-none"></i>
													<input type="file" id="upload" name="gambar" class="account-file-input" hidden accept="image/png, image/jpeg, image/webp" />
												</label>
												<p class="text-muted mb-0 small">Format Webp, JPG atau PNG. Maks 2MB.</p>
											</div>
										</div>
									</div>
								</div>

								<div class="mt-4 border-top pt-3 text-end">
									<a href="produk.php" class="btn btn-outline-secondary me-2">Batal</a>
									<button type="submit" name="submit" class="btn btn-primary">Simpan Produk</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="content-footer footer bg-footer-theme">
			<div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
				<div class="mb-2 mb-md-0">
					© <script>
						document.write(new Date().getFullYear());
					</script>
					,Toko Oleh-Oleh Majapahit. All rights reserved.
				</div>
			</div>
		</footer>
		<div class="content-backdrop fade"></div>
	</div>
</div>

<?php include('components/footer.php'); ?>

<script>
	const fileInput = document.querySelector('#upload');
	const preview = document.querySelector('#uploadedAvatar');

	fileInput.onchange = evt => {
		const [file] = fileInput.files
		if (file) {
			preview.src = URL.createObjectURL(file)
		}
	}
</script>