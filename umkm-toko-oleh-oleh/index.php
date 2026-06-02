<?php
include('config/koneksi.php');

if (!isset($_SESSION['keranjang'])) {
	$_SESSION['keranjang'] = [];
}
$query_kategori = mysqli_query($conn, "SELECT * FROM categories ORDER BY nama_kategori ASC");
$kategori_list = [];
while ($kat = mysqli_fetch_assoc($query_kategori)) {
	$kategori_list[] = $kat;
}

$query_produk = mysqli_query($conn, "SELECT p.*, c.nama_kategori 
                                     FROM products p 
                                     JOIN categories c ON p.id_category = c.id_category 
                                     ORDER BY p.id_product DESC");
$produk_list = [];
while ($prod = mysqli_fetch_assoc($query_produk)) {
	$produk_list[] = $prod;
}

$query_carousel = mysqli_query($conn, "SELECT * FROM products ORDER BY id_product DESC LIMIT 3");
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<title>Toko Oleh-Oleh Mojokerto</title>
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

	<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
		<div class="spinner-grow text-primary" role="status"></div>
	</div>
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
						<a href="index.php" class="nav-item nav-link active">Beranda</a>
						<a href="#katalog" class="nav-item nav-link">Katalog Produk</a>
						<a href="#kontak" class="nav-item nav-link">Kontak Kami</a>
					</div>
					<div class="d-flex m-3 me-0">
						<a href="cart.php" class="position-relative me-4 my-auto">
							<i class="fa fa-shopping-bag fa-2x text-primary"></i>
							<span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?= count($_SESSION['keranjang']); ?></span>
						</a>

						<?php if (isset($_SESSION['id_user'])) : ?>
							<div class="nav-item dropdown my-auto">
								<a href="#" class="nav-link dropdown-toggle d-flex align-items-center text-dark" data-bs-toggle="dropdown">
									<i class="fas fa-user fa-2x text-primary me-2"></i>
								</a>
								<div class="dropdown-menu m-0 bg-secondary rounded-0">
									<a href="#" class="dropdown-item">Profil Saya</a>
									<a href="#" class="dropdown-item">Pesanan Saya</a>
									<a href="logout.php" class="dropdown-item text-danger">Logout</a>
								</div>
							</div>
						<?php else : ?>
							<a href="login.php" class="my-auto btn btn-primary text-white rounded-pill px-4 py-2">Login</a>
						<?php endif; ?>
					</div>
				</div>
			</nav>
		</div>
	</div>
	<div class="container-fluid py-5 mb-5 hero-header">
		<div class="container py-5">
			<div class="row g-5 align-items-center">
				<div class="col-md-12 col-lg-7">
					<h4 class="mb-3 text-secondary">100% Khas & Autentik</h4>
					<h1 class="mb-5 display-3 text-primary">Pusat Oleh-Oleh Mojokerto</h1>

				</div>
				<div class="col-md-12 col-lg-5">
					<div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
						<div class="carousel-inner" role="listbox">
							<?php
							$active = true;
							while ($car = mysqli_fetch_assoc($query_carousel)):
							?>
								<div class="carousel-item <?= $active ? 'active' : ''; ?> rounded">
									<img src="assets/img/produk/<?= $car['gambar']; ?>" class="img-fluid w-100 h-100 bg-secondary rounded" alt="<?= $car['nama_produk']; ?>" style="object-fit: cover; height: 350px !important;">
									<a href="detail_produk.php?id=<?= $car['id_product']; ?>" class="btn px-4 py-2 text-white rounded bg-dark" style="opacity: 0.8;"><?= $car['nama_produk']; ?></a>
								</div>
							<?php $active = false;
							endwhile; ?>
						</div>
						<button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid featurs py-5">
		<div class="container py-5">
			<div class="row g-4">
				<div class="col-md-6 col-lg-4">
					<div class="featurs-item text-center rounded bg-light p-4 h-100">
						<div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
							<i class="fas fa-box-open fa-3x text-white"></i>
						</div>
						<div class="featurs-content text-center">
							<h5>Kualitas Terjamin</h5>
							<p class="mb-0">Produk selalu segar dan baru setiap hari</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="featurs-item text-center rounded bg-light p-4 h-100">
						<div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
							<i class="fas fa-shield-alt fa-3x text-white"></i>
						</div>
						<div class="featurs-content text-center">
							<h5>Pembayaran Aman</h5>
							<p class="mb-0">100% transaksi terenkripsi & aman</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="featurs-item text-center rounded bg-light p-4 h-100">
						<div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
							<i class="fa fa-phone-alt fa-3x text-white"></i>
						</div>
						<div class="featurs-content text-center">
							<h5>Layanan Pelanggan</h5>
							<p class="mb-0">Siap membantu Anda 24/7</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="katalog" class="container-fluid fruite py-5">
		<div class="container py-5">
			<div class="tab-class text-center">
				<div class="row g-4">
					<div class="col-lg-4 text-start">
						<h1>Katalog Produk</h1>
					</div>
					<div class="col-lg-8 text-end">
						<ul class="nav nav-pills d-inline-flex text-center mb-5">
							<li class="nav-item">
								<a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-semua">
									<span class="text-dark" style="width: 130px;">Semua Produk</span>
								</a>
							</li>
							<?php foreach ($kategori_list as $kat) : ?>
								<li class="nav-item">
									<a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-kat-<?= $kat['id_category']; ?>">
										<span class="text-dark" style="width: 130px;"><?= $kat['nama_kategori']; ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<div class="tab-content">
					<div id="tab-semua" class="tab-pane fade show p-0 active">
						<div class="row g-4">
							<?php foreach ($produk_list as $prod) : ?>
								<div class="col-md-6 col-lg-4 col-xl-3">
									<div class="rounded position-relative fruite-item d-flex flex-column h-100">
										<div class="fruite-img">
											<img src="assets/img/produk/<?= $prod['gambar']; ?>" class="img-fluid w-100 rounded-top" style="height: 200px; object-fit: cover;" alt="">
										</div>
										<div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?= $prod['nama_kategori']; ?></div>
										<div class="p-4 border border-secondary border-top-0 rounded-bottom d-flex flex-column flex-grow-1 text-start">
											<h5 class="fw-bold"><?= $prod['nama_produk']; ?></h5>
											<p class="flex-grow-1 text-muted small"><?= substr($prod['deskripsi'], 0, 55); ?>...</p>
											<div class="d-flex justify-content-between flex-lg-wrap mt-3 align-items-center">
												<p class="text-dark fs-5 fw-bold mb-0">Rp <?= number_format($prod['harga'], 0, ',', '.'); ?></p>

												<?php if (isset($_SESSION['id_user'])) : ?>
													<a href="cart.php?action=add&id=<?= $prod['id_product']; ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Beli</a>
												<?php else : ?>
													<a href="login.php?pesan=login_dulu" class="btn border border-secondary rounded-pill px-3 text-primary" title="Login untuk Beli"><i class="fa fa-shopping-bag me-2 text-primary"></i> Beli</a>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<?php foreach ($kategori_list as $kat) : ?>
						<div id="tab-kat-<?= $kat['id_category']; ?>" class="tab-pane fade show p-0">
							<div class="row g-4">
								<?php
								$ada_produk = false;
								foreach ($produk_list as $prod) :
									// Hanya tampilkan produk yang ID kategorinya cocok
									if ($prod['id_category'] == $kat['id_category']) :
										$ada_produk = true;
								?>
										<div class="col-md-6 col-lg-4 col-xl-3">
											<div class="rounded position-relative fruite-item d-flex flex-column h-100">
												<div class="fruite-img">
													<img src="assets/img/produk/<?= $prod['gambar']; ?>" class="img-fluid w-100 rounded-top" style="height: 200px; object-fit: cover;" alt="">
												</div>
												<div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?= $prod['nama_kategori']; ?></div>
												<div class="p-4 border border-secondary border-top-0 rounded-bottom d-flex flex-column flex-grow-1 text-start">
													<h5 class="fw-bold"><?= $prod['nama_produk']; ?></h5>
													<p class="flex-grow-1 text-muted small"><?= substr($prod['deskripsi'], 0, 55); ?>...</p>
													<div class="d-flex justify-content-between flex-lg-wrap mt-3 align-items-center">
														<p class="text-dark fs-5 fw-bold mb-0">Rp <?= number_format($prod['harga'], 0, ',', '.'); ?></p>
														<?php if (isset($_SESSION['id_user'])) : ?>
															<a href="cart.php?action=add&id=<?= $prod['id_product']; ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Beli</a>
														<?php else : ?>
															<a href="login.php?pesan=login_dulu" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Beli</a>
														<?php endif; ?>
													</div>
												</div>
											</div>
										</div>
								<?php
									endif;
								endforeach;

								// Jika kategori tersebut belum ada produknya
								if (!$ada_produk) {
									echo "<div class='col-12 text-center py-5'><h5 class='text-muted'>Belum ada produk di kategori ini.</h5></div>";
								}
								?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="kontak" class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
		<div class="container py-5">
			<div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
				<div class="row g-4">
					<div class="col-lg-3">
						<a href="#">
							<h1 class="text-primary mb-0">Oleh-Olehku</h1>
							<p class="text-secondary mb-0">Khas Mojokerto</p>
						</a>
					</div>
					<div class="col-lg-6">
						<div class="position-relative mx-auto">
							<input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="email" placeholder="Email Anda untuk promo menarik">
							<button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Berlangganan</button>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="d-flex justify-content-end pt-3">
							<a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
							<a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
							<a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-instagram"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="row g-5">
				<div class="col-lg-6 col-md-6">
					<div class="footer-item">
						<h4 class="text-light mb-3">Tentang Kami</h4>
						<p class="mb-4">Kami adalah pusat perbelanjaan oleh-oleh khas Mojokerto terlengkap yang menyediakan produk kerajinan, keripik, dan minuman dengan kualitas terbaik untuk dibawa pulang.</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="footer-item text-md-end">
						<h4 class="text-light mb-3">Kontak Info</h4>
						<p>Alamat: Jl. Majapahit No. 123, Mojokerto</p>
						<p>Email: halo@oleholehku.com</p>
						<p>WhatsApp: +62 812-3456-7890</p>
						<p>Pembayaran via Transfer Bank Terpercaya</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid copyright bg-dark py-4">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center text-md-start mb-3 mb-md-0">
					<span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Oleh-Olehku</a>, All right reserved.</span>
				</div>
			</div>
		</div>
	</div>
	<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="user/lib/easing/easing.min.js"></script>
	<script src="user/lib/waypoints/waypoints.min.js"></script>
	<script src="user/lib/lightbox/js/lightbox.min.js"></script>
	<script src="user/lib/owlcarousel/owl.carousel.min.js"></script>

	<script src="user/js/main.js"></script>
</body>

</html>