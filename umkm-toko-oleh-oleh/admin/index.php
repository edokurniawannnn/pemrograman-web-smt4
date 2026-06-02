<?php
include('../config/koneksi.php');

$q_produk = mysqli_query($conn, "SELECT COUNT(id_product) as total FROM products");
$d_produk = mysqli_fetch_assoc($q_produk);
$total_produk = $d_produk['total'];

$total_pesanan = 0;
$total_pendapatan = 0;

$q_pesanan = @mysqli_query($conn, "SELECT COUNT(*) as total_trx, SUM(total_harga) as pendapatan FROM orders");
if ($q_pesanan) {
	$d_pesanan = mysqli_fetch_assoc($q_pesanan);
	$total_pesanan = $d_pesanan['total_trx'] ?? 0;
	$total_pendapatan = $d_pesanan['pendapatan'] ?? 0;
}

$q_kategori = mysqli_query($conn, "SELECT c.nama_kategori, COUNT(p.id_product) as jumlah_produk 
                                   FROM categories c 
                                   LEFT JOIN products p ON c.id_category = p.id_category 
                                   GROUP BY c.id_category 
                                   ORDER BY jumlah_produk DESC LIMIT 3");


$q_terbaru = @mysqli_query($conn, "SELECT * FROM orders ORDER BY id_order DESC LIMIT 3");

include('components/header.php');
include('components/sidebar.php');
?>

<div class="layout-page">

	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">
		<div class="container-xxl flex-grow-1 container-p-y">

			<div class="row">
				<div class="col-lg-4 col-md-12 col-6 mb-4">
					<div class="card h-100">
						<div class="card-body">
							<div class="card-title d-flex align-items-start justify-content-between">
								<div class="avatar flex-shrink-0">
									<span class="avatar-initial rounded bg-label-primary"><i class="bx bx-box bx-sm"></i></span>
								</div>
							</div>
							<span class="fw-semibold d-block mb-1">Total Produk</span>
							<h3 class="card-title mb-2"><?= $total_produk; ?></h3>
							<small class="text-primary fw-semibold">Tersedia di Katalog</small>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-12 col-6 mb-4">
					<div class="card h-100">
						<div class="card-body">
							<div class="card-title d-flex align-items-start justify-content-between">
								<div class="avatar flex-shrink-0">
									<span class="avatar-initial rounded bg-label-info"><i class="bx bx-cart bx-sm"></i></span>
								</div>
							</div>
							<span class="fw-semibold d-block mb-1">Jumlah Transaksi</span>
							<h3 class="card-title mb-2"><?= number_format($total_pesanan, 0, ',', '.'); ?></h3>
							<small class="text-info fw-semibold">Pesanan Masuk</small>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-12 col-12 mb-4">
					<div class="card h-100">
						<div class="card-body">
							<div class="card-title d-flex align-items-start justify-content-between">
								<div class="avatar flex-shrink-0">
									<span class="avatar-initial rounded bg-label-success"><i class="bx bx-wallet bx-sm"></i></span>
								</div>
							</div>
							<span class="fw-semibold d-block mb-1">Total Pendapatan</span>
							<h3 class="card-title mb-2">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h3>
							<small class="text-success fw-semibold">Pendapatan Kotor</small>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 col-lg-6 mb-4">
					<div class="card h-100">
						<div class="card-header d-flex align-items-center justify-content-between pb-0">
							<div class="card-title mb-0">
								<h5 class="m-0 me-2">Distribusi Kategori Produk</h5>
								<small class="text-muted">Berdasarkan jumlah item tersedia</small>
							</div>
						</div>
						<div class="card-body mt-4">
							<ul class="p-0 m-0">
								<?php
								$warna_badge = ['bg-label-warning', 'bg-label-success', 'bg-label-info'];
								$i = 0;
								while ($kat = mysqli_fetch_assoc($q_kategori)) {
									$bg = $warna_badge[$i % 3];
								?>
									<li class="d-flex mb-4 pb-1">
										<div class="avatar flex-shrink-0 me-3">
											<span class="avatar-initial rounded <?= $bg; ?>"><i class="bx bx-purchase-tag"></i></span>
										</div>
										<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
											<div class="me-2">
												<h6 class="mb-0"><?= $kat['nama_kategori']; ?></h6>
											</div>
											<div class="user-progress">
												<small class="fw-semibold"><?= $kat['jumlah_produk']; ?> Item</small>
											</div>
										</div>
									</li>
								<?php $i++;
								} ?>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-6 mb-4">
					<div class="card h-100">
						<div class="card-header d-flex align-items-center justify-content-between">
							<h5 class="card-title m-0 me-2">Transaksi Terbaru</h5>
						</div>
						<div class="card-body">
							<ul class="p-0 m-0">
								<?php
								if ($q_terbaru && mysqli_num_rows($q_terbaru) > 0) {
									while ($trx = mysqli_fetch_assoc($q_terbaru)) {
								?>
										<li class="d-flex mb-4 pb-1">
											<div class="avatar flex-shrink-0 me-3">
												<span class="avatar-initial rounded bg-label-primary"><i class="bx bx-transfer"></i></span>
											</div>
											<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
												<div class="me-2">
													<small class="text-muted d-block mb-1"><?= $trx['metode_pembayaran'] ?? 'Transfer'; ?></small>
													<h6 class="mb-0"><?= $trx['nama_pelanggan'] ?? 'Pelanggan'; ?></h6>
												</div>
												<div class="user-progress d-flex align-items-center gap-1">
													<h6 class="mb-0 text-success">+ Rp <?= number_format($trx['total_harga'] ?? 0, 0, ',', '.'); ?></h6>
												</div>
											</div>
										</li>
								<?php
									}
								} else {
									// Tampilkan pesan jika tabel pesanan kosong atau belum ada
									echo "<div class='text-center mt-4 text-muted'>Belum ada data transaksi.</div>";
								}
								?>
							</ul>
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
					, Toko Oleh-Oleh Majapahit. All rights reserved.
				</div>
			</div>
		</footer>
		<div class="content-backdrop fade"></div>
	</div>
</div>
<?php include('components/footer.php'); ?>