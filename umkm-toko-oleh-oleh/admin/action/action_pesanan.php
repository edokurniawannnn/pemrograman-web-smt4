<?php
include('../../config/koneksi.php');

if (isset($_POST['aksi']) && $_POST['aksi'] == 'edit') {

	$id_order = intval($_POST['id_order']);
	$status   = mysqli_real_escape_string($conn, $_POST['status']);

	$query = "UPDATE orders SET status='$status' WHERE id_order='$id_order'";
	$result = mysqli_query($conn, $query);

	if ($result) {
		$_SESSION['pesan'] = 'Status pesanan berhasil diperbarui.';
		$_SESSION['tipe'] = 'success';
	} else {
		$_SESSION['pesan'] = 'Gagal memperbarui status pesanan.';
		$_SESSION['tipe'] = 'danger';
	}

	header("Location: ../data_pesanan.php");
	exit;
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {

	$id_order = intval($_GET['id']);

	mysqli_query($conn, "DELETE FROM orders WHERE id_order='$id_order'");
	mysqli_query($conn, "DELETE FROM order_details WHERE id_order='$id_order'");

	$hapus = mysqli_query($conn, "DELETE FROM orders WHERE id_order='$id_order'");

	if ($hapus) {
		$_SESSION['pesan'] = 'Data pesanan berhasil dihapus.';
		$_SESSION['tipe'] = 'success';
	} else {
		$_SESSION['pesan'] = 'Gagal menghapus data pesanan.';
		$_SESSION['tipe'] = 'danger';
	}

	header("Location: ../data_pesanan.php");
	exit;
}

$_SESSION['pesan'] = 'Aksi tidak valid.';
$_SESSION['tipe'] = 'warning';

header("Location: ../data_pesanan.php");
exit;
