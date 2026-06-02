<?php
include('../../config/koneksi.php');

if (isset($_POST['submit'])) {

	$nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
	$id_category = mysqli_real_escape_string($conn, $_POST['id_category']);
	$stok        = mysqli_real_escape_string($conn, $_POST['stok']);
	$harga       = mysqli_real_escape_string($conn, $_POST['harga']);
	$deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);

	$nama_file_asli = $_FILES['gambar']['name'];
	$ukuran_file    = $_FILES['gambar']['size'];
	$error          = $_FILES['gambar']['error'];
	$tmp_name       = $_FILES['gambar']['tmp_name'];

	$nama_file_baru = "";

	if ($error === 0) {

		$ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
		$pecah_nama     = explode('.', $nama_file_asli);
		$ekstensi_file  = strtolower(end($pecah_nama));

		if (!in_array($ekstensi_file, $ekstensi_valid)) {
			$_SESSION['pesan'] = "Gagal! Ekstensi file hanya boleh JPG, JPEG, PNG, atau WEBP.";
			$_SESSION['tipe']  = "danger";
			header("Location: ../tambah_produk.php");
			exit;
		}

		if ($ukuran_file > 2000000) {
			$_SESSION['pesan'] = "Gagal! Ukuran gambar maksimal 2MB.";
			$_SESSION['tipe']  = "danger";
			header("Location: ../tambah_produk.php");
			exit;
		}

		$nama_file_baru = uniqid() . '.' . $ekstensi_file;

		$folder_tujuan = '../../assets/img/produk/' . $nama_file_baru;

		// Pindahkan file dari memori sementara ke folder tujuan
		move_uploaded_file($tmp_name, $folder_tujuan);
	}


	$query_insert = "INSERT INTO products (id_category, nama_produk, deskripsi, harga, stok, gambar) 
                 VALUES ('$id_category', '$nama_produk', '$deskripsi', '$harga', '$stok', '$nama_file_baru')";

	$eksekusi = mysqli_query($conn, $query_insert);

	if ($eksekusi) {
		$_SESSION['pesan'] = "Berhasil! Produk baru telah ditambahkan ke katalog UMKM.";
		$_SESSION['tipe'] = "success";
		header("Location: ../produk.php");
		exit;
	} else {
		$_SESSION['pesan'] = "Gagal! Terjadi kesalahan sistem: " . mysqli_error($conn);
		$_SESSION['tipe'] = "danger";
		header("Location: ../tambah_produk.php");
		exit;
	}
}
