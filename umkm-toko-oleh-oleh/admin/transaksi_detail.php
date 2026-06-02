<?php
include('../config/koneksi.php');
include('components/header.php');
include('components/sidebar.php');

if (!isset($_GET['id'])) {
	header("Location: data_pesanan.php");
	exit;
}

$id = intval($_GET['id']);

$query = "SELECT orders.*, users.nama_lengkap, users.email, users.no_hp
		  FROM orders
		  JOIN users ON orders.id_user = users.id_user
		  WHERE orders.id_order = '$id'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
	header("Location: data_pesanan.php");
	exit;
}

$detail = mysqli_query($conn, "
	SELECT order_detail.*, produk.nama_produk, produk.gambar
	FROM order_detail
	JOIN produk ON order_detail.id_produk = produk.id_produk
	WHERE order_detail.id_order = '$id'
");
?>

<div class="layout-page">
	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">

		<div class="container-xxl flex-grow-1 container-p-y">

			<h4 class="fw-bold py-3 mb-4">
				<span class="text-muted fw-light">Transaksi /</span> Detail Pesanan
			</h4>

			<div class="row">

				<!-- Data Pemesan -->
				<div class="col-md-5">
					<div class="card mb-4">
						<h5 class="card-header">Informasi Pelanggan</h5>

						<div class="card-body">

							<p class="mb-2">
								<strong>Nama:</strong><br>
								<?= $data['nama_lengkap']; ?>
							</p>

							<p class="mb-2">
								<strong>Email:</strong><br>
								<?= $data['email']; ?>
							</p>

							<p class="mb-2">
								<strong>No HP:</strong><br>
								<?= $data['no_hp']; ?>
							</p>

							<p class="mb-2">
								<strong>Alamat:</strong><br>
								<?= $data['alamat']; ?>
							</p>

							<p class="mb-2">
								<strong>Tanggal Order:</strong><br>
								<?= date('d M Y H:i', strtotime($data['tanggal_order'])); ?>
							</p>

							<p class="mb-0">
								<strong>Status:</strong><br>

								<?php
								$badge = 'bg-label-secondary';

								if ($data['status'] == 'diproses') $badge = 'bg-label-warning';
								if ($data['status'] == 'dikirim') $badge = 'bg-label-info';
								if ($data['status'] == 'selesai') $badge = 'bg-label-success';
								if ($data['status'] == 'batal') $badge = 'bg-label-danger';
								?>

								<span class="badge <?= $badge; ?>">
									<?= ucfirst($data['status']); ?>
								</span>
							</p>

						</div>
					</div>
				</div>

				<!-- Detail Produk -->
				<div class="col-md-7">
					<div class="card">
						<h5 class="card-header">Produk Dipesan</h5>

						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Produk</th>
										<th>Harga</th>
										<th>Qty</th>
										<th>Subtotal</th>
									</tr>
								</thead>

								<tbody>

									<?php while ($row = mysqli_fetch_assoc($detail)) { ?>

										<tr>
											<td>
												<div class="d-flex align-items-center">
													<img src="../assets/img/produk/<?= $row['gambar']; ?>"
														width="45"
														class="rounded me-3">

													<div>
														<?= $row['nama_produk']; ?>
													</div>
												</div>
											</td>

											<td>
												Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
											</td>

											<td>
												<?= $row['qty']; ?>
											</td>

											<td class="fw-semibold">
												Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?>
											</td>
										</tr>

									<?php } ?>

								</tbody>

								<tfoot>
									<tr>
										<td colspan="3" class="text-end fw-bold">
											Total Bayar :
										</td>

										<td class="fw-bold text-primary">
											Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?>
										</td>
									</tr>
								</tfoot>

							</table>
						</div>

						<div class="card-body border-top">
							<a href="data_pesanan.php" class="btn btn-secondary">
								<i class="bx bx-arrow-back"></i> Kembali
							</a>

							<a href="update_status.php?id=<?= $data['id_order']; ?>" class="btn btn-warning">
								<i class="bx bx-refresh"></i> Update Status
							</a>
						</div>

					</div>
				</div>

			</div>

		</div>

	</div>
</div>

<?php include('components/footer.php'); ?>