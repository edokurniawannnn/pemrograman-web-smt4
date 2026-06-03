<?php
session_start();
include_once 'koneksi.php';

if (!isset($_SESSION['username'])) {
	echo "
	<script>
		alert('Silakan login dulu');
		window.location='login.php';
	</script>
	";

	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
</head>

<body>
	<h1>INI DASBOR</h1>

	<h3>
		Selamat Datang,
		<?= $_SESSION['username']; ?>
	</h3>
	<a href="aksi.php?proses=logout">logout</a>
</body>

</html>