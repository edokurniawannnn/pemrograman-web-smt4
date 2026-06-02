<?php
include('../config/koneksi.php');
include('components/header.php');
include('components/sidebar.php');

$query = "SELECT c.id_category, c.nama_kategori, COUNT(p.id_product) as jumlah_produk 
          FROM categories c 
          LEFT JOIN products p ON c.id_category = p.id_category 
          GROUP BY c.id_category 
          ORDER BY c.id_category DESC";
$result = mysqli_query($conn, $query);
?>

<div class="layout-page">
	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">
		<div class="container-xxl flex-grow-1 container-p-y">
			<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manajemen Toko /</span> Kategori Produk</h4>

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
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
					<span class="tf-icons bx bx-plus"></span>&nbsp; Tambah Kategori Baru
				</button>
			</div>

			<div class="card">
				<h5 class="card-header">Daftar Kategori Oleh-Oleh Mojokerto</h5>
				<div class="table-responsive text-nowrap">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Kategori</th>
								<th>Total Produk</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody class="table-border-bottom-0">
							<?php
							$no = 1;
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) {
							?>
									<tr>
										<td><?= $no++; ?></td>
										<td><strong class="text-primary"><?= $row['nama_kategori']; ?></strong></td>
										<td>
											<?php if ($row['jumlah_produk'] > 0) : ?>
												<span class="badge bg-label-success"><?= $row['jumlah_produk']; ?> Item</span>
											<?php else : ?>
												<span class="badge bg-label-secondary">Kosong</span>
											<?php endif; ?>
										</td>
										<td>
											<div class="d-flex gap-2">
												<button type="button" class="btn btn-sm btn-warning btn-edit"
													data-bs-toggle="modal"
													data-bs-target="#modalEditKategori"
													data-id="<?= $row['id_category']; ?>"
													data-nama="<?= $row['nama_kategori']; ?>"
													title="Edit">
													<i class="bx bx-edit-alt"></i>
												</button>

												<button type="button" class="btn btn-sm btn-danger btn-hapus"
													data-bs-toggle="modal"
													data-bs-target="#modalKonfirmasiHapus"
													data-id="<?= $row['id_category']; ?>"
													data-nama="<?= $row['nama_kategori']; ?>"
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
									<td colspan="4" class="text-center py-4">Belum ada data kategori.</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="bx bx-plus-circle text-primary me-2"></i>Tambah Kategori</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="action/action_kategori_produk.php" method="POST">
				<div class="modal-body">
					<input type="hidden" name="aksi" value="tambah">

					<div class="mb-3">
						<label for="namaKategoriBaru" class="form-label">Nama Kategori</label>
						<input type="text" id="namaKategoriBaru" name="nama_kategori" class="form-control" placeholder="Contoh: Makanan Ringan" required />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" name="submit" class="btn btn-primary">Simpan Kategori</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modalEditKategori" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="bx bx-edit-alt text-warning me-2"></i>Edit Kategori</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="action/action_kategori_produk.php" method="POST">
				<div class="modal-body">
					<input type="hidden" name="aksi" value="edit">
					<input type="hidden" name="id_category" id="editIdKategori">

					<div class="mb-3">
						<label for="editNamaKategori" class="form-label">Nama Kategori</label>
						<input type="text" id="editNamaKategori" name="nama_kategori" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" name="submit" class="btn btn-warning text-white">Update Kategori</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php include('components/footer.php'); ?>

<script>
	document.querySelectorAll('.btn-edit').forEach(button => {
		button.addEventListener('click', function() {
			const id = this.getAttribute('data-id');
			const nama = this.getAttribute('data-nama');

			document.getElementById('editIdKategori').value = id;
			document.getElementById('editNamaKategori').value = nama;
		});
	});

	var modalHapus = document.getElementById('modalKonfirmasiHapus');
	if (modalHapus) {
		modalHapus.addEventListener('show.bs.modal', function(event) {
			var button = event.relatedTarget;
			if (button.classList.contains('btn-hapus')) {
				var id = button.getAttribute('data-id');
				var nama = button.getAttribute('data-nama');

				modalHapus.querySelector('#teksNamaProduk').textContent = nama;
				modalHapus.querySelector('#tombolEksekusiHapus').href = 'action/action_kategori_produk.php?aksi=hapus&id=' + id;
			}
		});
	}
</script>