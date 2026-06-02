<?php
include('../config/koneksi.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
	header("Location: produk.php");
	exit;
}

$id_product = mysqli_real_escape_string($conn, $_GET['id']);

$query_produk = "SELECT * FROM products WHERE id_product = '$id_product'";
$result_produk = mysqli_query($conn, $query_produk);

if (mysqli_num_rows($result_produk) == 0) {
	header("Location: produk.php");
	exit;
}

$data = mysqli_fetch_assoc($result_produk);

$query_kat = "SELECT * FROM categories ORDER BY nama_kategori ASC";
$result_kat = mysqli_query($conn, $query_kat);

include('components/header.php');
include('components/sidebar.php');
?>

<div class="layout-page">
	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">
		<div class="container-xxl flex-grow-1 container-p-y">
			<h4 class="fw-bold py-3 mb-4">
				<span class="text-muted fw-light">Manajemen Toko / <a href="produk.php" class="text-muted fw-light">Produk</a> /</span> Edit Produk
			</h4>

			<div class="row">
				<div class="col-xl">
					<div class="card mb-4">
						<div class="card-header d-flex justify-content-between align-items-center">
							<h5 class="mb-0">Ubah Data Produk: <?= $data['nama_produk']; ?></h5>
							<small class="text-muted">#PRD-<?= str_pad($data['id_product'], 4, '0', STR_PAD_LEFT); ?></small>
						</div>
						<div class="card-body">
							<form action="action/action_edit_produk.php" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="id_product" value="<?= $data['id_product']; ?>">

								<div class="row">
									<div class="col-md-8">
										<div class="mb-3">
											<label class="form-label" for="nama_produk">Nama Produk</label>
											<input type="text" name="nama_produk" class="form-control" id="nama_produk"
												value="<?= $data['nama_produk']; ?>" required />
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<label class="form-label">Kategori Produk</label>
												<input type="hidden" name="id_category" id="id_category_hidden" value="<?= $data['id_category']; ?>" required>

												<div class="dropdown">
													<button class="btn btn-primary dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
														type="button" id="btnKategoriDropdown" data-bs-toggle="dropdown">
														<?php
														// Mencari nama kategori produk yang terpilih saat ini
														mysqli_data_seek($result_kat, 0);
														$nama_terpilih = "-- Pilih Kategori --";
														while ($k = mysqli_fetch_array($result_kat)) {
															if ($k['id_category'] == $data['id_category']) $nama_terpilih = $k['nama_kategori'];
														}
														?>
														<span id="teksKategoriTerpilih"><?= $nama_terpilih; ?></span>
													</button>
													<ul class="dropdown-menu w-100">
														<?php
														mysqli_data_seek($result_kat, 0);
														while ($kat = mysqli_fetch_array($result_kat)) {
														?>
															<li>
																<a class="dropdown-item item-kategori" href="javascript:void(0);" data-id="<?= $kat['id_category']; ?>">
																	<?= $kat['nama_kategori']; ?>
																</a>
															</li>
														<?php } ?>
													</ul>
												</div>
											</div>
											<div class="col-md-6 mb-3">
												<label class="form-label" for="stok">Stok Saat Ini</label>
												<input type="number" name="stok" id="stok" class="form-control" value="<?= $data['stok']; ?>" required />
											</div>
										</div>

										<div class="mb-3">
											<label class="form-label" for="harga">Harga Jual</label>
											<div class="input-group">
												<span class="input-group-text">Rp</span>
												<input type="number" name="harga" id="harga" class="form-control" value="<?= $data['harga']; ?>" required />
											</div>
										</div>

										<div class="mb-3">
											<label class="form-label" for="deskripsi">Deskripsi</label>
											<textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= $data['deskripsi']; ?></textarea>
										</div>
									</div>

									<div class="col-md-4 border-start">
										<div class="mb-3">
											<label class="form-label">Foto Produk</label>
											<div class="mb-3 text-center">
												<?php
												$path_gambar = !empty($data['gambar']) ? "../assets/img/produk/" . $data['gambar'] : "../assets/img/illustrations/page-misc-error-light.png";
												?>
												<img src="<?= $path_gambar; ?>" alt="preview" class="rounded shadow-sm" height="200" width="100%" id="uploadedAvatar" style="object-fit: cover;" />
											</div>
											<div class="button-wrapper text-center">
												<label for="upload" class="btn btn-outline-primary w-100 mb-2">
													<span>Ganti Foto</span>
													<input type="file" id="upload" name="gambar" hidden accept="image/png, image/jpeg, image/webp" />
												</label>
												<p class="text-muted small mb-0 text-start">*Kosongkan jika tidak ingin mengganti foto.</p>
											</div>
										</div>
									</div>
								</div>

								<div class="mt-4 border-top pt-3 text-end">
									<a href="produk.php" class="btn btn-outline-secondary me-2">Batal</a>
									<button type="submit" name="submit" class="btn btn-warning text-white">Perbarui Produk</button>
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