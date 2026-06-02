<?php
session_start();
include('../config/koneksi.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
	$_SESSION['pesan'] = "Gagal! Anda harus memilih produk terlebih dahulu.";
	$_SESSION['tipe']  = "warning";
	header("Location: produk.php");
	exit;
}

$id_product = mysqli_real_escape_string($conn, $_GET['id']);

$query = "SELECT products.*, categories.nama_kategori 
          FROM products 
          JOIN categories ON products.id_category = categories.id_category 
          WHERE products.id_product = '$id_product'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
	$_SESSION['pesan'] = "Gagal! Data produk tidak ditemukan.";
	$_SESSION['tipe']  = "danger";
	header("Location: produk.php");
	exit;
}

$produk = mysqli_fetch_assoc($result);

include('components/header.php');
include('components/sidebar.php');
?>

<div class="layout-page">
	<?php include('components/navbar.php'); ?>

	<div class="content-wrapper">
		<div class="container-xxl flex-grow-1 container-p-y">
			<h4 class="fw-bold py-3 mb-4">
				<span class="text-muted fw-light">Manajemen Toko / <a href="produk.php" class="text-muted fw-light">Produk</a> /</span> Detail Produk
			</h4>

			<div class="card mb-4">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">Informasi Detail Produk</h5>
					<a href="produk.php" class="btn btn-sm btn-outline-secondary">
						<i class="bx bx-arrow-back"></i> Kembali
					</a>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-4 mb-4 mb-md-0 text-center border-end pe-md-4">
							<?php
							if (!empty($produk['gambar'])) :
							?>
								<img src="../assets/img/produk/<?= $produk['gambar']; ?>"
									alt="<?= $produk['nama_produk']; ?>"
									class="img-fluid rounded shadow-sm"
									style="max-height: 350px; object-fit: cover; width: 100%;">
							<?php else : ?>
								<div class="bg-label-secondary d-flex justify-content-center align-items-center rounded shadow-sm" style="height: 300px; width: 100%;">
									<h1 class="display-1 text-muted mb-0">
										<?= strtoupper(substr($produk['nama_produk'], 0, 2)); ?>
									</h1>
								</div>
							<?php endif; ?>
						</div>

						<div class="col-md-8 ps-md-4">
							<h3 class="mb-2 fw-bold text-primary"><?= $produk['nama_produk']; ?></h3>

							<div class="mb-4">
								<span class="badge bg-label-primary fs-6 me-2"><?= $produk['nama_kategori']; ?></span>

								<?php if ($produk['stok'] <= 5): ?>
									<span class="badge bg-label-danger fs-6"><i class="bx bx-error-circle"></i> Sisa Stok: <?= $produk['stok']; ?></span>
								<?php else: ?>
									<span class="badge bg-label-success fs-6"><i class="bx bx-check-circle"></i> Stok Tersedia: <?= $produk['stok']; ?></span>
								<?php endif; ?>
							</div>

							<table class="table table-borderless mb-4">
								<tbody>
									<tr>
										<td class="px-0 py-2 text-muted w-25"><strong>Harga Jual</strong></td>
										<td class="px-0 py-2">
											<h4 class="mb-0 text-success fw-bold">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></h4>
										</td>
									</tr>
									<tr>
										<td class="px-0 py-2 text-muted"><strong>ID Produk</strong></td>
										<td class="px-0 py-2">#PRD-<?= str_pad($produk['id_product'], 4, '0', STR_PAD_LEFT); ?></td>
									</tr>
								</tbody>
							</table>

							<div>
								<h6 class="fw-bold text-muted mb-2">Deskripsi Produk:</h6>
								<div class="bg-lighter p-3 rounded text-dark" style="min-height: 100px;">
									<?= !empty($produk['deskripsi']) ? nl2br($produk['deskripsi']) : "<em>Tidak ada deskripsi untuk produk ini.</em>"; ?>
								</div>
							</div>

							<div class="mt-4 pt-3 border-top">
								<a href="edit_produk.php?id=<?= $produk['id_product']; ?>" class="btn btn-warning me-2">
									<i class="bx bx-edit-alt"></i> Edit Data
								</a>
								<button type="button"
									class="btn btn-sm btn-danger"
									data-bs-toggle="modal"
									data-bs-target="#modalKonfirmasiHapus"
									data-id="<?= $produk['id_product']; ?>"
									data-nama="<?= $produk['nama_produk']; ?>"
									title="Hapus">
									<i class="bx bx-trash"></i>
								</button>
							</div>
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