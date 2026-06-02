<?php
include('../config/koneksi.php');
include('components/header.php');
include('components/sidebar.php');

$query = "SELECT orders.*, users.nama_lengkap
          FROM orders
          JOIN users ON orders.id_user = users.id_user
          ORDER BY orders.tanggal_order DESC";

$result = mysqli_query($conn, $query);
?>

<div class="layout-page">

	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">

		<div class="container-xxl flex-grow-1 container-p-y">

			<h4 class="fw-bold py-3 mb-4">
				<span class="text-muted fw-light">Transaksi /</span> Data Pesanan
			</h4>
			<?php if (isset($_SESSION['pesan'])) : ?>
				<div class="alert alert-<?= $_SESSION['tipe']; ?> alert-dismissible" role="alert">
					<?= $_SESSION['pesan']; ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>

			<?php
				unset($_SESSION['pesan']);
				unset($_SESSION['tipe']);
			endif;
			?>
			<div class="card">
				<h5 class="card-header">Riwayat Transaksi Pelanggan</h5>

				<div class="table-responsive text-nowrap">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Nama Pelanggan</th>
								<th>Total Bayar</th>
								<th>Metode</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>

						<tbody class="table-border-bottom-0">

							<?php
							$no = 1;
							while ($row = mysqli_fetch_assoc($result)) {

								$status_class = 'bg-label-secondary';

								if ($row['status'] == 'pending') $status_class = 'bg-label-secondary';
								if ($row['status'] == 'diproses') $status_class = 'bg-label-warning';
								if ($row['status'] == 'selesai') $status_class = 'bg-label-success';
								if ($row['status'] == 'batal') $status_class = 'bg-label-danger';
							?>

								<tr>
									<td><?= $no++; ?></td>

									<td>
										<?= date('d M Y', strtotime($row['tanggal_order'])); ?><br>
										<small class="text-muted"><?= date('H:i', strtotime($row['tanggal_order'])); ?></small>
									</td>

									<td><strong><?= $row['nama_lengkap']; ?></strong></td>

									<td class="text-primary fw-bold">
										Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?>
									</td>

									<td>
										<?= !empty($row['payment_method']) ? $row['payment_method'] : 'Transfer'; ?>
									</td>

									<td>
										<span class="badge <?= $status_class; ?>">
											<?= ucfirst($row['status']); ?>
										</span>
									</td>

									<td>
										<div class="d-flex gap-2">

											<!-- Detail -->
											<button type="button"
												class="btn btn-sm btn-info btn-detail-order"
												data-bs-toggle="modal"
												data-bs-target="#modalDetailPesanan"

												data-id="<?= $row['id_order']; ?>"
												data-nama="<?= $row['nama_lengkap']; ?>"
												data-tanggal="<?= date('d M Y H:i', strtotime($row['tanggal_order'])); ?>"
												data-total="Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?>"
												data-metode="<?= $row['payment_method']; ?>"
												data-status="<?= ucfirst($row['status']); ?>">
												<i class="bx bx-show"></i>
											</button>

											<!-- Edit -->
											<button type="button"
												class="btn btn-sm btn-warning btn-edit-order"
												data-bs-toggle="modal"
												data-bs-target="#modalEditPesanan"

												data-id="<?= $row['id_order']; ?>"
												data-status="<?= $row['status']; ?>">
												<i class="bx bx-edit"></i>
											</button>

											<!-- Hapus -->
											<button type="button"
												class="btn btn-sm btn-danger btn-hapus-order"
												data-bs-toggle="modal"
												data-bs-target="#modalHapusPesanan"

												data-id="<?= $row['id_order']; ?>"
												data-nama="<?= $row['nama_lengkap']; ?>">
												<i class="bx bx-trash"></i>
											</button>

										</div>
									</td>

								</tr>

							<?php } ?>

						</tbody>

					</table>
				</div>
			</div>

		</div>

	</div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetailPesanan" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title">Detail Pesanan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<div class="modal-body">
				<p><strong>ID Order :</strong> <span id="detailId"></span></p>
				<p><strong>Nama :</strong> <span id="detailNama"></span></p>
				<p><strong>Tanggal :</strong> <span id="detailTanggal"></span></p>
				<p><strong>Total :</strong> <span id="detailTotal"></span></p>
				<p><strong>Metode :</strong> <span id="detailMetode"></span></p>
				<p><strong>Status :</strong> <span id="detailStatus"></span></p>
			</div>

		</div>
	</div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEditPesanan" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title">Update Status Pesanan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<form action="action/action_pesanan.php" method="POST">

				<div class="modal-body">

					<input type="hidden" name="aksi" value="edit">
					<input type="hidden" name="id_order" id="editIdOrder">

					<div class="mb-3">
						<label class="form-label">Status</label>
						<select name="status" id="editStatus" class="form-select">
							<option value="pending">Pending</option>
							<option value="diproses">Diproses</option>
							<option value="dikirim">Dikirim</option>
							<option value="selesai">Selesai</option>
							<option value="batal">Batal</option>
						</select>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-warning">Update</button>
				</div>

			</form>

		</div>
	</div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="modalHapusPesanan" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title">Konfirmasi Hapus</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<div class="modal-body">
				Apakah yakin ingin menghapus pesanan milik
				<strong id="namaHapus"></strong> ?
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
				<a href="#" id="btnHapusPesanan" class="btn btn-danger">Hapus</a>
			</div>

		</div>
	</div>
</div>

<?php include('components/footer.php'); ?>

<script>
	document.querySelectorAll('.btn-detail-order').forEach(btn => {
		btn.addEventListener('click', function() {
			document.getElementById('detailId').textContent = this.dataset.id;
			document.getElementById('detailNama').textContent = this.dataset.nama;
			document.getElementById('detailTanggal').textContent = this.dataset.tanggal;
			document.getElementById('detailTotal').textContent = this.dataset.total;
			document.getElementById('detailMetode').textContent = this.dataset.metode;
			document.getElementById('detailStatus').textContent = this.dataset.status;
		});
	});

	document.querySelectorAll('.btn-edit-order').forEach(btn => {
		btn.addEventListener('click', function() {
			document.getElementById('editIdOrder').value = this.dataset.id;
			document.getElementById('editStatus').value = this.dataset.status;
		});
	});

	document.querySelectorAll('.btn-hapus-order').forEach(btn => {
		btn.addEventListener('click', function() {
			document.getElementById('namaHapus').textContent = this.dataset.nama;
			document.getElementById('btnHapusPesanan').href =
				'action/action_pesanan.php?aksi=hapus&id=' + this.dataset.id;
		});
	});
</script>