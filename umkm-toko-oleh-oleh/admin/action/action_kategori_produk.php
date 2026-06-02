<?php
session_start();
include('../../config/koneksi.php');

$aksi = $_REQUEST['aksi'] ?? '';

if ($aksi == 'tambah' && isset($_POST['submit'])) {

	$nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

	$query = "INSERT INTO categories (nama_kategori) VALUES ('$nama_kategori')";
	$eksekusi = mysqli_query($conn, $query);

	if ($eksekusi) {
		$_SESSION['pesan'] = "Berhasil! Kategori baru telah ditambahkan.";
		$_SESSION['tipe']  = "success";
	} else {
		$_SESSION['pesan'] = "Gagal! Nama kategori mungkin sudah ada.";
		$_SESSION['tipe']  = "danger";
	}
} elseif ($aksi == 'edit' && isset($_POST['submit'])) {

	$id_category   = mysqli_real_escape_string($conn, $_POST['id_category']);
	$nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

	$query = "UPDATE categories SET nama_kategori = '$nama_kategori' WHERE id_category = '$id_category'";
	$eksekusi = mysqli_query($conn, $query);

	if ($eksekusi) {
		$_SESSION['pesan'] = "Berhasil! Nama kategori telah diperbarui.";
		$_SESSION['tipe']  = "success";
	} else {
		$_SESSION['pesan'] = "Gagal memperbarui kategori.";
		$_SESSION['tipe']  = "danger";
	}
} elseif ($aksi == 'hapus' && isset($_GET['id'])) {

	$id_category = mysqli_real_escape_string($conn, $_GET['id']);

	$cek_produk = mysqli_query($conn, "SELECT id_product FROM products WHERE id_category = '$id_category' LIMIT 1");

	if (mysqli_num_rows($cek_produk) > 0) {
		$_SESSION['pesan'] = "Gagal! Kategori tidak bisa dihapus karena masih memiliki produk di dalamnya.";
		$_SESSION['tipe']  = "warning";
	} else {
		$query = "DELETE FROM categories WHERE id_category = '$id_category'";
		$eksekusi = mysqli_query($conn, $query);

		if ($eksekusi) {
			$_SESSION['pesan'] = "Berhasil! Kategori telah dihapus.";
			$_SESSION['tipe']  = "success";
		} else {
			$_SESSION['pesan'] = "Gagal menghapus kategori.";
			$_SESSION['tipe']  = "danger";
		}
	}
}

header("Location: ../kategori_produk.php");
exit;
