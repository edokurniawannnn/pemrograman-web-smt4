<?php
include('config/koneksi.php');

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php?pesan=login_dulu");
	exit;
}

if (empty($_SESSION['keranjang'])) {
	header("Location: index.php");
	exit;
}

$error_msg = '';

if (isset($_POST['proses_pesanan'])) {
	$id_user = $_SESSION['id_user'];
	$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
	$tanggal_order = date('Y-m-d H:i:s');

	$total_final = 0;
	$ids = implode(',', array_keys($_SESSION['keranjang']));
	$q_hitung = mysqli_query($conn, "SELECT id_product, harga, stok FROM products WHERE id_product IN ($ids)");
	$data_produk_valid = [];
	while ($row = mysqli_fetch_assoc($q_hitung)) {
		$qty = $_SESSION['keranjang'][$row['id_product']];
		$total_final += ($row['harga'] * $qty);
		$data_produk_valid[] = $row;
	}

	mysqli_begin_transaction($conn);

	try {
		$query_order = "INSERT INTO orders (id_user, tanggal_order, total_harga, payment_method, status) 
                        VALUES ('$id_user', '$tanggal_order', '$total_final', '$payment_method', 'pending')";
		mysqli_query($conn, $query_order);

		$id_order_baru = mysqli_insert_id($conn);

		foreach ($data_produk_valid as $p) {
			$id_p = $p['id_product'];
			$qty = $_SESSION['keranjang'][$id_p];
			$subtotal = $p['harga'] * $qty;

			if ($p['stok'] < $qty) {
				throw new Exception("Stok produk '" . $p['nama_produk'] . "' tidak mencukupi.");
			}

			$query_detail = "INSERT INTO order_details (id_order, id_product, jumlah, subtotal) 
                             VALUES ('$id_order_baru', '$id_p', '$qty', '$subtotal')";
			mysqli_query($conn, $query_detail);

			$stok_baru = $p['stok'] - $qty;
			mysqli_query($conn, "UPDATE products SET stok = '$stok_baru' WHERE id_product = '$id_p'");
		}

		mysqli_commit($conn);

		unset($_SESSION['keranjang']);

		header("Location: index.php?pesan=order_sukses");
		exit;
	} catch (Exception $e) {
		mysqli_rollback($conn);
		$error_msg = $e->getMessage();
	}
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<title>Checkout - Oleh-Olehku</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<link href="user/css/bootstrap.min.css" rel="stylesheet">
	<link href="user/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
</head>

<body>
	<div class="container-fluid py-5">
		<div class="container py-5">
			<h1 class="mb-4">Detail Pengiriman</h1>

			<?php if ($error_msg != ''): ?>
				<div class="alert alert-danger"><?= $error_msg; ?></div>
			<?php endif; ?>

			<form action="" method="POST">
				<div class="row g-5">
					<div class="col-md-12 col-lg-6 col-xl-7">
						<div class="form-item">
							<label class="form-label my-3">Nama Lengkap Penerima</label>
							<input type="text" class="form-control" value="<?= $_SESSION['nama_lengkap']; ?>" readonly>
						</div>
						<div class="form-item">
							<label class="form-label my-3">Alamat Lengkap</label>
							<textarea class="form-control" spellcheck="false" cols="30" rows="5" placeholder="Jl. Raya No. 123, Mojokerto" required></textarea>
						</div>
						<div class="form-item">
							<label class="form-label my-3">Metode Pembayaran</label>
							<select name="payment_method" class="form-select" required>
								<option value="Transfer Bank">Transfer Bank (BCA/Mandiri)</option>
								<option value="E-Wallet">E-Wallet (OVO/Gopay)</option>
								<option value="COD">Bayar di Tempat (COD)</option>
							</select>
						</div>
					</div>

					<div class="col-md-12 col-lg-6 col-xl-5">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">Produk</th>
										<th scope="col">Nama</th>
										<th scope="col">Harga</th>
										<th scope="col">Qty</th>
										<th scope="col">Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$total_belanja = 0;
									$ids = implode(',', array_keys($_SESSION['keranjang']));
									$q_item = mysqli_query($conn, "SELECT * FROM products WHERE id_product IN ($ids)");
									while ($item = mysqli_fetch_assoc($q_item)):
										$qty = $_SESSION['keranjang'][$item['id_product']];
										$sub = $item['harga'] * $qty;
										$total_belanja += $sub;
									?>
										<tr>
											<th scope="row">
												<div class="d-flex align-items-center mt-2">
													<img src="assets/img/produk/<?= $item['gambar']; ?>" class="img-fluid rounded-circle" style="width: 50px; height: 50px;" alt="">
												</div>
											</th>
											<td class="py-4"><?= $item['nama_produk']; ?></td>
											<td class="py-4">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
											<td class="py-4"><?= $qty; ?></td>
											<td class="py-4">Rp <?= number_format($sub, 0, ',', '.'); ?></td>
										</tr>
									<?php endwhile; ?>
									<tr>
										<th scope="row"></th>
										<td class="py-5">
											<p class="mb-0 text-dark text-uppercase py-3">TOTAL BAYAR</p>
										</td>
										<td class="py-5"></td>
										<td class="py-5"></td>
										<td class="py-5">
											<div class="py-3 border-bottom border-top">
												<p class="mb-0 text-dark fw-bold">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></p>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row g-4 text-center align-items-center justify-content-center pt-4">
							<button type="submit" name="proses_pesanan" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Buat Pesanan Sekarang</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>

</html>