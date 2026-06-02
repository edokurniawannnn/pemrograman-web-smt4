<?php
session_start();
include('../../config/koneksi.php');

if (isset($_GET['id'])) {

	$id_product = mysqli_real_escape_string($conn, $_GET['id']);

	$query_gambar = "SELECT gambar FROM products WHERE id_product = '$id_product'";
	$result_gambar = mysqli_query($conn, $query_gambar);

	if (mysqli_num_rows($result_gambar) > 0) {
		$row = mysqli_fetch_assoc($result_gambar);
		$nama_file_gambar = $row['gambar'];

		if (!empty($nama_file_gambar)) {
			$path_gambar = '../../assets/img/produk/' . $nama_file_gambar;
			if (file_exists($path_gambar)) {
				unlink($path_gambar);
			}
		}
	}

	$query_hapus = "DELETE FROM products WHERE id_product = '$id_product'";
	$eksekusi = mysqli_query($conn, $query_hapus);

	if ($eksekusi) {
		$_SESSION['pesan'] = "Berhasil! Data produk beserta gambarnya telah dihapus.";
		$_SESSION['tipe']  = "success";
	} else {
		$_SESSION['pesan'] = "Gagal! Data tidak dapat dihapus. Error: " . mysqli_error($conn);
		$_SESSION['tipe']  = "danger";
	}
} else {
	$_SESSION['pesan'] = "Akses ditolak! ID produk tidak ditemukan.";
	$_SESSION['tipe']  = "warning";
}

header("Location: ../produk.php");
exit;
