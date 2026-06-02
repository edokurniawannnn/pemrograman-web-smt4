<?php
session_start();
include('config/koneksi.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
	header("Location: index.php");
	exit;
}

$id_product = mysqli_real_escape_string($conn, $_GET['id']);

$query = "SELECT p.*, c.nama_kategori 
          FROM products p 
          JOIN categories c ON p.id_category = c.id_category 
          WHERE p.id_product = '$id_product'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
	header("Location: index.php");
	exit;
}

$produk = mysqli_fetch_assoc($result);

$id_kat = $produk['id_category'];
$query_terkait = mysqli_query($conn, "SELECT * FROM products 
                                      WHERE id_category = '$id_kat' 
                                      AND id_product != '$id_product' 
                                      LIMIT 4");
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<title><?= $produk['nama_produk']; ?> - Toko Oleh-Oleh</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

	<link href="user/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
	<link href="user/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

	<link href="user/css/bootstrap.min.css" rel="stylesheet">

	<link href="user/css/style.css" rel="stylesheet">
</head>

<body>
	<div class="container-fluid fixed-top">
		<div class="container px-0">
			<nav class="navbar navbar-light bg-white navbar-expand-xl">
				<a href="index.php" class="navbar-brand">
					<h1 class="text-primary display-6">Oleh-Olehku</h1>
				</a>
				<button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
					<span class="fa fa-bars text-primary"></span>
				</button>
				<div class="collapse navbar-collapse bg-white" id="navbarCollapse">
					<div class="navbar-nav mx-auto">
						<a href="index.php" class="nav-item nav-link">Beranda</a>
						<a href="index.php#katalog" class="nav-item nav-link active">Katalog Produk</a>
					</div>
					<div class="d-flex m-3 me-0">
						<a href="cart.php" class="position-relative me-4 my-auto">
							<i class="fa fa-shopping-bag fa-2x text-primary"></i>
						</a>
						<?php if (isset($_SESSION['id_user'])) : ?>
							<a href="logout.php" class="my-auto btn btn-outline-danger">Logout</a>
						<?php else : ?>
							<a href="login.php" class="my-auto btn btn-primary text-white rounded-pill px-4">Login</a>
						<?php endif; ?>
					</div>
				</div>
			</nav>
		</div>
	</div>

	<div class="container-fluid page-header py-5">
		<h1 class="text-center text-white display-6">Detail Produk</h1>
		<ol class="breadcrumb justify-content-center mb-0">
			<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
			<li class="breadcrumb-item active text-white"><?= $produk['nama_produk']; ?></li>
		</ol>
	</div>

	<div class="container-fluid py-5 mt-5">
		<div class="container py-5">
			<div class="row g-4 mb-5">
				<div class="col-lg-8 col-xl-9">
					<div class="row g-4">
						<div class="col-lg-6">
							<div class="border rounded shadow-sm overflow-hidden">
								<a href="assets/img/produk/<?= $produk['gambar']; ?>" data-lightbox="product-img">
									<img src="assets/img/produk/<?= $produk['gambar']; ?>" class="img-fluid w-100" style="max-height: 450px; object-fit: cover;" alt="<?= $produk['nama_produk']; ?>">
								</a>
							</div>
						</div>
						<div class="col-lg-6 text-start">
							<h4 class="fw-bold mb-3 text-dark"><?= $produk['nama_produk']; ?></h4>
							<p class="mb-3 text-primary fw-bold fs-5">Kategori: <?= $produk['nama_kategori']; ?></p>
							<h5 class="fw-bold mb-3 text-danger fs-3">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></h5>

							<div class="mb-4">
								<span class="badge <?= $produk['stok'] > 0 ? 'bg-success' : 'bg-danger'; ?> px-3 py-2">
									<?= $produk['stok'] > 0 ? 'Stok Tersedia: ' . $produk['stok'] : 'Stok Habis'; ?>
								</span>
							</div>

							<p class="mb-4 text-muted">
								<?= nl2br($produk['deskripsi']); ?>
							</p>

							<div class="d-flex align-items-center mt-5">
								<?php if (isset($_SESSION['id_user'])) : ?>
									<a href="cart.php?action=add&id=<?= $produk['id_product']; ?>" class="btn border border-secondary rounded-pill px-4 py-2 text-primary">
										<i class="fa fa-shopping-bag me-2 text-primary"></i> Masukkan ke Keranjang
									</a>
								<?php else : ?>
									<a href="login.php?pesan=login_dulu" class="btn border border-secondary rounded-pill px-4 py-2 text-primary">
										<i class="fa fa-lock me-2 text-primary"></i> Login untuk Membeli
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-xl-3">
					<div class="row g-4 fruite">
						<div class="col-lg-12">
							<div class="mb-3">
								<h4>Produk Terkait</h4>
								<ul class="list-unstyled fruite-categorie mt-3">
									<?php
									if (mysqli_num_rows($query_terkait) > 0) :
										while ($terkait = mysqli_fetch_assoc($query_terkait)) :
									?>
											<li>
												<div class="d-flex align-items-center mb-3">
													<img src="assets/img/produk/<?= $terkait['gambar']; ?>" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover;" alt="">
													<div class="ms-3">
														<a href="detail_produk.php?id=<?= $terkait['id_product']; ?>" class="h6 mb-0 d-block"><?= $terkait['nama_produk']; ?></a>
														<small class="text-danger fw-bold">Rp <?= number_format($terkait['harga'], 0, ',', '.'); ?></small>
													</div>
												</div>
											</li>
									<?php
										endwhile;
									else:
										echo "<li><small class='text-muted'>Belum ada produk terkait.</small></li>";
									endif;
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
		<div class="container py-5 text-center">
			<p class="mb-0">&copy; <a class="text-secondary" href="#">Oleh-Olehku Mojokerto</a>. All rights reserved.</p>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="user/lib/easing/easing.min.js"></script>
	<script src="user/lib/waypoints/waypoints.min.js"></script>
	<script src="user/lib/lightbox/js/lightbox.min.js"></script>
	<script src="user/lib/owlcarousel/owl.carousel.min.js"></script>
	<script src="user/js/main.js"></script>
</body>

</html>