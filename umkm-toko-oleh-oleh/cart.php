<?php
include('config/koneksi.php');

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php?pesan=login_dulu");
	exit;
}

if (!isset($_SESSION['keranjang'])) {
	$_SESSION['keranjang'] = [];
}

if (isset($_GET['action'])) {
	$action = $_GET['action'];
	$id_product = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if ($action == 'add' && $id_product > 0) {
		if (isset($_SESSION['keranjang'][$id_product])) {
			$_SESSION['keranjang'][$id_product] += 1; // 
		} else {
			$_SESSION['keranjang'][$id_product] = 1;
		}
		header("Location: cart.php");
		exit;
	} elseif ($action == 'remove' && $id_product > 0) {
		unset($_SESSION['keranjang'][$id_product]);
		header("Location: cart.php");
		exit;
	} elseif ($action == 'update' && isset($_POST['qty'])) {
		foreach ($_POST['qty'] as $id => $qty) {
			if ($qty > 0) {
				$_SESSION['keranjang'][$id] = intval($qty);
			} else {
				unset($_SESSION['keranjang'][$id]); // Jika diisi 0, hapus dari keranjang
			}
		}
		header("Location: cart.php");
		exit;
	}
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<title>Keranjang Belanja - Oleh-Olehku</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

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
						<a href="index.php#katalog" class="nav-item nav-link">Katalog Produk</a>
					</div>
					<div class="d-flex m-3 me-0">
						<a href="cart.php" class="position-relative me-4 my-auto">
							<i class="fa fa-shopping-bag fa-2x text-primary"></i>
							<span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?= count($_SESSION['keranjang']); ?></span>
						</a>
						<a href="logout.php" class="my-auto btn btn-outline-danger rounded-pill px-4">Logout</a>
					</div>
				</div>
			</nav>
		</div>
	</div>
	<div class="container-fluid page-header py-5">
		<h1 class="text-center text-white display-6">Keranjang Belanja</h1>
		<ol class="breadcrumb justify-content-center mb-0">
			<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
			<li class="breadcrumb-item active text-white">Keranjang</li>
		</ol>
	</div>
	<div class="container-fluid py-5">
		<div class="container py-5">
			<?php if (empty($_SESSION['keranjang'])) : ?>
				<div class="text-center py-5">
					<i class="fa fa-shopping-cart fa-5x text-secondary mb-4"></i>
					<h3 class="fw-bold mb-3">Keranjang Belanja Kosong</h3>
					<p class="text-muted mb-4">Sepertinya Anda belum memilih produk apapun.</p>
					<a href="index.php#katalog" class="btn btn-primary rounded-pill py-2 px-4 text-white">Mulai Belanja</a>
				</div>
			<?php else : ?>
				<form action="cart.php?action=update" method="POST">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Produk</th>
									<th scope="col">Nama</th>
									<th scope="col">Harga</th>
									<th scope="col">Kuantitas</th>
									<th scope="col">Subtotal</th>
									<th scope="col">Hapus</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$total_belanja = 0;
								// Tarik data produk berdasarkan ID yang ada di session
								$ids = implode(',', array_keys($_SESSION['keranjang']));
								$query_cart = mysqli_query($conn, "SELECT * FROM products WHERE id_product IN ($ids)");

								while ($row = mysqli_fetch_assoc($query_cart)) {
									$id_prod = $row['id_product'];
									$qty = $_SESSION['keranjang'][$id_prod];
									$subtotal = $row['harga'] * $qty;
									$total_belanja += $subtotal;
								?>
									<tr>
										<th scope="row">
											<div class="d-flex align-items-center">
												<img src="assets/img/produk/<?= $row['gambar']; ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="">
											</div>
										</th>
										<td>
											<p class="mb-0 mt-4"><a href="detail_produk.php?id=<?= $id_prod; ?>" class="text-dark fw-bold"><?= $row['nama_produk']; ?></a></p>
										</td>
										<td>
											<p class="mb-0 mt-4">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
										</td>
										<td>
											<div class="input-group quantity mt-4" style="width: 100px;">
												<div class="input-group-btn">
												</div>
												<input type="number" name="qty[<?= $id_prod; ?>]" class="form-control form-control-sm text-center border-0" value="<?= $qty; ?>" min="1" max="<?= $row['stok']; ?>">
											</div>
										</td>
										<td>
											<p class="mb-0 mt-4 fw-bold">Rp <?= number_format($subtotal, 0, ',', '.'); ?></p>
										</td>
										<td>
											<a href="cart.php?action=remove&id=<?= $id_prod; ?>" class="btn btn-md rounded-circle bg-light border mt-4" onclick="return confirm('Hapus produk ini dari keranjang?');">
												<i class="fa fa-times text-danger"></i>
											</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

					<div class="mt-4 d-flex justify-content-between">
						<a href="index.php#katalog" class="btn btn-outline-secondary rounded-pill py-2 px-4">Lanjut Belanja</a>
						<button type="submit" class="btn btn-warning rounded-pill py-2 px-4 text-white">Update Keranjang</button>
					</div>
				</form>

				<div class="row g-4 justify-content-end mt-5">
					<div class="col-8"></div>
					<div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
						<div class="bg-light rounded">
							<div class="p-4">
								<h1 class="display-6 mb-4">Total <span class="fw-normal">Belanja</span></h1>
								<div class="d-flex justify-content-between mb-4">
									<h5 class="mb-0 me-4">Subtotal:</h5>
									<p class="mb-0">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></p>
								</div>
								<div class="d-flex justify-content-between">
									<h5 class="mb-0 me-4">Biaya Admin:</h5>
									<div class="">
										<p class="mb-0">Rp 0</p>
									</div>
								</div>
							</div>
							<div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
								<h5 class="mb-0 ps-4 me-4 text-primary fw-bold">Total Pembayaran</h5>
								<p class="mb-0 pe-4 text-primary fw-bold">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></p>
							</div>
							<div class="d-grid px-4 pb-4">
								<a href="checkout.php" class="btn border-secondary rounded-pill text-primary text-uppercase py-3">Proses Checkout</a>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
		<div class="container py-5 text-center">
			<p class="mb-0">&copy; <a class="text-secondary" href="#">Oleh-Olehku Mojokerto</a>. All rights reserved.</p>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>