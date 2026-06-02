<?php
include('../config/koneksi.php');
include('components/header.php');
include('components/sidebar.php');

// Query untuk mengambil data produk
$query = "SELECT products.*, categories.nama_kategori 
          FROM products 
          JOIN categories ON products.id_category = categories.id_category 
          ORDER BY products.id_product DESC";
$result = mysqli_query($conn, $query);
?>

<div class="layout-page">
	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">
		<div class="container-xxl flex-grow-1 container-p-y">
			<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manajemen Toko /</span> Produk</h4>

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
			<div class="mb-4">
				<a href="tambah_produk.php" class="btn btn-primary">
					<span class="tf-icons bx bx-plus"></span>&nbsp; Tambah Produk Baru
				</a>
			</div>

			<div class="card">
				<h5 class="card-header">Daftar Produk Oleh-Oleh Mojokerto</h5>
				<div class="table-responsive text-nowrap">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Gambar</th>
								<th>Nama Produk</th>
								<th>Kategori</th>
								<th>Harga</th>
								<th>Stok</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody class="table-border-bottom-0">
							<?php
							$no = 1;
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_array($result)) {
							?>
									<tr>
										<td><?= $no++; ?></td>
										<td>
											<?php if ($row['gambar']): ?>
												<img src="../assets/img/produk/<?= $row['gambar']; ?>" alt="<?= $row['nama_produk']; ?>" class="rounded" width="50">
											<?php else: ?>
												<div class="avatar avatar-md">
													<span class="avatar-initial rounded bg-label-secondary">
														<?= strtoupper(substr($row['nama_produk'], 0, 2)); ?>
													</span>
												</div>
											<?php endif; ?>
										</td>
										<td><strong><?= $row['nama_produk']; ?></strong></td>
										<td>
											<span class="badge bg-label-primary"><?= $row['nama_kategori']; ?></span>
										</td>
										<td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
										<td>
											<?php if ($row['stok'] <= 5): ?>
												<span class="badge bg-label-danger">Sisa <?= $row['stok']; ?></span>
											<?php else: ?>
												<span class="badge bg-label-success"><?= $row['stok']; ?></span>
											<?php endif; ?>
										</td>
										<td>
											<div class="d-flex gap-2">
												<a href="detail_produk.php?id=<?= $row['id_product']; ?>" class="btn btn-sm btn-info">
													<i class="bx bx-show-alt"></i>
												</a>
												<a href="edit_produk.php?id=<?= $row['id_product']; ?>" class="btn btn-sm btn-warning">
													<i class="bx bx-edit-alt"></i>
												</a>
												<button type="button"
													class="btn btn-sm btn-danger"
													data-bs-toggle="modal"
													data-bs-target="#modalKonfirmasiHapus"
													data-id="<?= $row['id_product']; ?>"
													data-nama="<?= $row['nama_produk']; ?>"
													title="Hapus">
													<i class="bx bx-trash"></i>
												</button>
											</div>
										</td>
									</tr>
								<?php
								}
							} else {
								?>
								<tr>
									<td colspan="7" class="text-center">Belum ada data produk.</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
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