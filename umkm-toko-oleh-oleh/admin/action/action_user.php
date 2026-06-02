<?php
session_start();
include('../../config/koneksi.php');

$aksi = $_REQUEST['aksi'] ?? '';

if ($aksi == 'tambah' && isset($_POST['submit'])) {

	$nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
	$username     = mysqli_real_escape_string($conn, $_POST['username']);
	$role         = mysqli_real_escape_string($conn, $_POST['role']);

	$password     = password_hash($_POST['password'], PASSWORD_BCRYPT);

	$query = "INSERT INTO users (username, password, nama_lengkap, role) 
              VALUES ('$username', '$password', '$nama_lengkap', '$role')";

	$eksekusi = mysqli_query($conn, $query);

	if ($eksekusi) {
		$_SESSION['pesan'] = "Berhasil! User baru telah ditambahkan.";
		$_SESSION['tipe']  = "success";
	} else {
		$_SESSION['pesan'] = "Gagal! Username mungkin sudah digunakan.";
		$_SESSION['tipe']  = "danger";
	}
} elseif ($aksi == 'edit' && isset($_POST['submit'])) {

	$id_user      = mysqli_real_escape_string($conn, $_POST['id_user']);
	$nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
	$username     = mysqli_real_escape_string($conn, $_POST['username']);
	$role         = mysqli_real_escape_string($conn, $_POST['role']);

	if (!empty($_POST['password'])) {
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$query = "UPDATE users SET 
                  username = '$username', 
                  password = '$password', 
                  nama_lengkap = '$nama_lengkap', 
                  role = '$role' 
                  WHERE id_user = '$id_user'";
	} else {
		$query = "UPDATE users SET 
                  username = '$username', 
                  nama_lengkap = '$nama_lengkap', 
                  role = '$role' 
                  WHERE id_user = '$id_user'";
	}

	$eksekusi = mysqli_query($conn, $query);

	if ($eksekusi) {
		$_SESSION['pesan'] = "Berhasil! Data user telah diperbarui.";
		$_SESSION['tipe']  = "success";
	} else {
		$_SESSION['pesan'] = "Gagal memperbarui data user.";
		$_SESSION['tipe']  = "danger";
	}
} elseif ($aksi == 'hapus' && isset($_GET['id'])) {

	$id_user = mysqli_real_escape_string($conn, $_GET['id']);


	if (isset($_SESSION['id_user']) && $id_user == $_SESSION['id_user']) {
		$_SESSION['pesan'] = "Gagal! Anda tidak dapat menghapus akun Anda sendiri.";
		$_SESSION['tipe']  = "warning";
	} else {
		$query = "DELETE FROM users WHERE id_user = '$id_user'";
		$eksekusi = mysqli_query($conn, $query);

		if ($eksekusi) {
			$_SESSION['pesan'] = "Berhasil! User telah dihapus dari sistem.";
			$_SESSION['tipe']  = "success";
		} else {
			$_SESSION['pesan'] = "Gagal menghapus user.";
			$_SESSION['tipe']  = "danger";
		}
	}
}

header("Location: ../user.php");
exit;
