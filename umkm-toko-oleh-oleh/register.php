<?php
include('config/koneksi.php');

if (isset($_SESSION['id_user'])) {
	header("Location: index.php");
	exit;
}

$error_msg = '';

if (isset($_POST['register'])) {
	$nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
	$username     = mysqli_real_escape_string($conn, $_POST['username']);
	$password     = $_POST['password'];
	$konfirmasi   = $_POST['konfirmasi_password'];

	if ($password !== $konfirmasi) {
		$error_msg = "Gagal! Password dan Konfirmasi Password tidak cocok.";
	} else {
		$cek_username = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

		if (mysqli_num_rows($cek_username) > 0) {
			$error_msg = "Gagal! Username '$username' sudah terdaftar. Silakan gunakan yang lain.";
		} else {
			$hashed_password = password_hash($password, PASSWORD_BCRYPT);

			$query_insert = "INSERT INTO users (username, password, nama_lengkap, role) 
                             VALUES ('$username', '$hashed_password', '$nama_lengkap', 'user')";

			if (mysqli_query($conn, $query_insert)) {
				header("Location: login.php?pesan=register_sukses");
				exit;
			} else {
				$error_msg = "Terjadi kesalahan sistem saat menyimpan data.";
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<title>Daftar Akun - Toko Oleh-Oleh Mojokerto</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<link href="user/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />

	<style>
		body {
			background-color: #f4f6f8;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 2rem 0;
		}

		.register-card {
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
			<div class="col-md-8 col-lg-6">
				<div class="card register-card p-4">
					<div class="card-body text-center">
						<h2 class="brand-text mb-2">Oleh-Olehku</h2>
						<h5 class="text-muted mb-4">Buat akun pelanggan baru</h5>

						<?php if ($error_msg != '') : ?>
							<div class="alert alert-danger py-2 mb-4 text-start" role="alert">
								<i class="fas fa-times-circle me-2"></i><?= $error_msg; ?>
							</div>
						<?php endif; ?>

						<form action="" method="POST" class="text-start">
							<div class="mb-3">
								<label for="nama_lengkap" class="form-label fw-bold">Nama Lengkap</label>
								<div class="input-group">
									<span class="input-group-text bg-white"><i class="fas fa-id-card text-muted"></i></span>
									<input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Contoh: Budi Santoso" value="<?= isset($_POST['nama_lengkap']) ? $_POST['nama_lengkap'] : ''; ?>" required autofocus>
								</div>
							</div>

							<div class="mb-3">
								<label for="username" class="form-label fw-bold">Username</label>
								<div class="input-group">
									<span class="input-group-text bg-white"><i class="fas fa-user text-muted"></i></span>
									<input type="text" class="form-control" id="username" name="username" placeholder="Buat username unik" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mb-3">
									<label for="password" class="form-label fw-bold">Password</label>
									<input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
								</div>
								<div class="col-md-6 mb-4">
									<label for="konfirmasi_password" class="form-label fw-bold">Ulangi Password</label>
									<input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ketik ulang password" required>
								</div>
							</div>

							<div class="d-grid mb-3">
								<button type="submit" name="register" class="btn btn-primary text-white py-2 fw-bold" style="border-radius: 10px;">Daftar Akun</button>
							</div>
						</form>

						<div class="mt-4">
							<p class="mb-0 text-muted">Sudah punya akun? <a href="login.php" class="text-primary fw-bold text-decoration-none">Login di sini</a></p>
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