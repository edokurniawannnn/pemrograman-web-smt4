<?php
include('../config/koneksi.php');
include('components/header.php');
include('components/sidebar.php');

$query = "SELECT * FROM users ORDER BY nama_lengkap ASC";
$result = mysqli_query($conn, $query);
?>

<div class="layout-page">
	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">
		<div class="container-xxl flex-grow-1 container-p-y">
			<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sistem /</span> Manajemen User</h4>

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
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
					<span class="tf-icons bx bx-user-plus"></span>&nbsp; Tambah User Baru
				</button>
			</div>

			<div class="card">
				<h5 class="card-header">Daftar Pengguna Sistem</h5>
				<div class="table-responsive text-nowrap">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Lengkap</th>
								<th>Username</th>
								<th>Role</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody class="table-border-bottom-0">
							<?php
							$no = 1;
							while ($row = mysqli_fetch_assoc($result)) {
							?>
								<tr>
									<td><?= $no++; ?></td>
									<td><strong><?= $row['nama_lengkap']; ?></strong></td>
									<td><?= $row['username']; ?></td>
									<td>
										<?php if ($row['role'] == 'admin') : ?>
											<span class="badge bg-label-danger">Administrator</span>
										<?php else : ?>
											<span class="badge bg-label-info">Pelanggan</span>
										<?php endif; ?>
									</td>
									<td>
										<div class="d-flex gap-2">
											<button type="button" class="btn btn-sm btn-warning btn-edit-user"
												data-bs-toggle="modal"
												data-bs-target="#modalEditUser"
												data-id="<?= $row['id_user']; ?>"
												data-nama="<?= $row['nama_lengkap']; ?>"
												data-user="<?= $row['username']; ?>"
												data-role="<?= $row['role']; ?>">
												<i class="bx bx-edit-alt"></i>
											</button>

											<button type="button" class="btn btn-sm btn-danger btn-hapus"
												data-bs-toggle="modal"
												data-bs-target="#modalKonfirmasiHapus"
												data-id="<?= $row['id_user']; ?>"
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

<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah User Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="action/action_user.php" method="POST">
				<div class="modal-body">
					<input type="hidden" name="aksi" value="tambah">
					<div class="mb-3">
						<label class="form-label">Nama Lengkap</label>
						<input type="text" name="nama_lengkap" class="form-control" required />
					</div>
					<div class="mb-3">
						<label class="form-label">Username</label>
						<input type="text" name="username" class="form-control" required />
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="password" class="form-control" required />
					</div>
					<div class="mb-3">
						<label class="form-label">Role</label>
						<select name="role" class="form-select" required>
							<option value="user">Pelanggan</option>
							<option value="admin">Administrator</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" name="submit" class="btn btn-primary">Simpan User</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Data User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="action/action_user.php" method="POST">
				<div class="modal-body">
					<input type="hidden" name="aksi" value="edit">
					<input type="hidden" name="id_user" id="editIdUser">
					<div class="mb-3">
						<label class="form-label">Nama Lengkap</label>
						<input type="text" name="nama_lengkap" id="editNamaLengkap" class="form-control" required />
					</div>
					<div class="mb-3">
						<label class="form-label">Username</label>
						<input type="text" name="username" id="editUsername" class="form-control" required />
					</div>
					<div class="mb-3">
						<label class="form-label">Password Baru</label>
						<input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ganti" />
					</div>
					<div class="mb-3">
						<label class="form-label">Role</label>
						<select name="role" id="editRole" class="form-select" required>
							<option value="user">Pelanggan</option>
							<option value="admin">Administrator</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" name="submit" class="btn btn-warning text-white">Update User</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php include('components/footer.php'); ?>

<script>
	document.querySelectorAll('.btn-edit-user').forEach(button => {
		button.addEventListener('click', function() {
			document.getElementById('editIdUser').value = this.getAttribute('data-id');
			document.getElementById('editNamaLengkap').value = this.getAttribute('data-nama');
			document.getElementById('editUsername').value = this.getAttribute('data-user');
			document.getElementById('editRole').value = this.getAttribute('data-role');
		});
	});

	var modalHapus = document.getElementById('modalKonfirmasiHapus');
	modalHapus.addEventListener('show.bs.modal', function(event) {
		var button = event.relatedTarget;
		if (button.classList.contains('btn-danger')) {
			var id = button.getAttribute('data-id');
			var nama = button.getAttribute('data-nama');
			modalHapus.querySelector('#teksNamaProduk').textContent = nama;
			modalHapus.querySelector('#tombolEksekusiHapus').href = 'action/action_user.php?aksi=hapus&id=' + id;
		}
	});
</script>