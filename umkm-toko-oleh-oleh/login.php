<?php
include('config/koneksi.php');

if (isset($_SESSION['id_user'])) {
	if ($_SESSION['role'] == 'admin') {
		header("Location: admin/index.php");
	} else {
		header("Location: index.php");
	}
	exit;
}

$error_msg = '';

$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';

if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = $_POST['password'];
	$redirect_url = $_POST['redirect_url'];

	$query = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) === 1) {
		$user = mysqli_fetch_assoc($result);

		if (password_verify($password, $user['password'])) {

			$_SESSION['id_user']      = $user['id_user'];
			$_SESSION['username']     = $user['username'];
			$_SESSION['nama_lengkap'] = $user['nama_lengkap'];
			$_SESSION['role']         = $user['role'];

			if ($user['role'] == 'admin') {
				header("Location: admin/index.php");
				exit;
			} else {
				if (!empty($redirect_url)) {
					header("Location: $redirect_url");
				} else {
					header("Location: index.php");
				}
				exit;
			}
		} else {
			$error_msg = "Gagal! Password yang Anda masukkan salah.";
		}
	} else {
		$error_msg = "Gagal! Username tidak terdaftar di sistem.";
	}
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<title>Login - Toko Oleh-Oleh Mojokerto</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<link href="user/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />

	<style>
		body {
			background-color: #f4f6f8;
			height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.login-card {
			border: none;
			border-radius: 15px;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
		}

		.brand-text {
			font-weight: 800;
			color: #81c408;
			/* Warna hijau primary Fruitables */
		}
	</style>
</head>

<body>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 col-lg-5">
				<div class="card login-card p-4">
					<div class="card-body text-center">
						<h2 class="brand-text mb-4">Oleh-Olehku</h2>
						<h5 class="text-muted mb-4">Silakan masuk ke akun Anda</h5>

						<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'login_dulu') : ?>
							<div class="alert alert-warning py-2 mb-4" role="alert">
								<i class="fas fa-exclamation-circle me-2"></i>Anda harus login untuk melanjutkan aksi.
							</div>
						<?php endif; ?>
						<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'logout_sukses') : ?>
							<div class="alert alert-success py-2 mb-4 text-start" role="alert">
								<i class="fas fa-check-circle me-2"></i>Anda berhasil keluar dari sistem.
							</div>
						<?php endif; ?>

						<?php if ($error_msg != '') : ?>
							<div class="alert alert-danger py-2 mb-4" role="alert">
								<i class="fas fa-times-circle me-2"></i><?= $error_msg; ?>
							</div>
						<?php endif; ?>

						<form action="" method="POST" class="text-start">
							<input type="hidden" name="redirect_url" value="<?= $redirect; ?>">

							<div class="mb-3">
								<label for="username" class="form-label fw-bold">Username</label>
								<div class="input-group">
									<span class="input-group-text bg-white"><i class="fas fa-user text-muted"></i></span>
									<input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autofocus>
								</div>
							</div>

							<div class="mb-4">
								<label for="password" class="form-label fw-bold">Password</label>
								<div class="input-group">
									<span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
									<input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
								</div>
							</div>

							<div class="d-grid mb-3">
								<button type="submit" name="login" class="btn btn-primary text-white py-2 fw-bold" style="border-radius: 10px;">Masuk</button>
							</div>
						</form>

						<div class="mt-4">
							<p class="mb-0 text-muted">Belum punya akun? <a href="register.php" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a></p>
							<a href="index.php" class="text-muted small mt-2 d-inline-block text-decoration-none"><i class="fas fa-arrow-left me-1"></i>Kembali ke Halaman Utama</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>