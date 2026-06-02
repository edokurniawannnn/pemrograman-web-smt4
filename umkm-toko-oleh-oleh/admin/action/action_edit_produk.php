<?php
session_start();
// Mundur dua tingkat folder untuk mengakses koneksi
include('../../config/koneksi.php');

if (isset($_POST['submit'])) {

	// 1. Ambil data dari form dan bersihkan dari SQL Injection
	$id_product  = mysqli_real_escape_string($conn, $_POST['id_product']);
	$nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
	$id_category = mysqli_real_escape_string($conn, $_POST['id_category']);
	$stok        = mysqli_real_escape_string($conn, $_POST['stok']);
	$harga       = mysqli_real_escape_string($conn, $_POST['harga']);
	$deskripsi   = mysqli_real_escape_string($conn, $_POST['deskripsi']);

	// Validasi tambahan jika kategori kosong
	if (empty($id_category)) {
		$_SESSION['pesan'] = "Gagal! Anda wajib memilih Kategori Produk.";
		$_SESSION['tipe']  = "danger";
		// Redirect kembali ke halaman edit dengan membawa parameter ID produk
		header("Location: ../edit_produk.php?id=$id_product");
		exit;
	}

	// 2. Persiapkan variabel untuk file gambar
	$nama_file_asli = $_FILES['gambar']['name'];
	$ukuran_file    = $_FILES['gambar']['size'];
	$error          = $_FILES['gambar']['error'];
	$tmp_name       = $_FILES['gambar']['tmp_name'];

	// 3. LOGIKA CEK GAMBAR (Apakah admin mengunggah gambar baru?)
	// Error 0 berarti ada file baru yang diunggah
	if ($error === 0) {
		$ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
		$pecah_nama     = explode('.', $nama_file_asli);
		$ekstensi_file  = strtolower(end($pecah_nama));

		// Validasi Ekstensi
		if (!in_array($ekstensi_file, $ekstensi_valid)) {
			$_SESSION['pesan'] = "Gagal! Ekstensi file hanya boleh JPG, JPEG, PNG, atau WEBP.";
			$_SESSION['tipe']  = "danger";
			header("Location: ../edit_produk.php?id=$id_product");
			exit;
		}

		// Validasi Ukuran (Maksimal 2MB)
		if ($ukuran_file > 2000000) {
			$_SESSION['pesan'] = "Gagal! Ukuran gambar maksimal 2MB.";
			$_SESSION['tipe']  = "danger";
			header("Location: ../edit_produk.php?id=$id_product");
			exit;
		}

		// =========================================================
		// HAPUS GAMBAR LAMA SECARA FISIK SEBELUM UPLOAD YANG BARU
		// =========================================================
		$query_gambar_lama = "SELECT gambar FROM products WHERE id_product = '$id_product'";
		$result_gambar = mysqli_query($conn, $query_gambar_lama);
		if (mysqli_num_rows($result_gambar) > 0) {
			$row = mysqli_fetch_assoc($result_gambar);
			if (!empty($row['gambar'])) {
				$path_gambar_lama = '../../assets/img/produk/' . $row['gambar'];
				// Jika file fisik lama ada, hapus (unlink)
				if (file_exists($path_gambar_lama)) {
					unlink($path_gambar_lama);
				}
			}
		}

		// Generate nama file baru
		$nama_file_baru = uniqid() . '.' . $ekstensi_file;
		$folder_tujuan = '../../assets/img/produk/' . $nama_file_baru;

		// Pindahkan file gambar baru ke folder
		move_uploaded_file($tmp_name, $folder_tujuan);

		// 4A. Query Update (TERMASUK GAMBAR)
		$query_update = "UPDATE products SET 
                         id_category = '$id_category', 
                         nama_produk = '$nama_produk', 
                         deskripsi = '$deskripsi', 
                         harga = '$harga', 
                         stok = '$stok', 
                         gambar = '$nama_file_baru' 
                         WHERE id_product = '$id_product'";
	} else {
		// 4B. Query Update (TANPA GAMBAR)
		// Jika error bernilai 4 (tidak ada file diunggah), update teksnya saja
		$query_update = "UPDATE products SET 
                         id_category = '$id_category', 
                         nama_produk = '$nama_produk', 
                         deskripsi = '$deskripsi', 
                         harga = '$harga', 
                         stok = '$stok' 
                         WHERE id_product = '$id_product'";
	}

	// 5. Eksekusi Query
	$eksekusi = mysqli_query($conn, $query_update);

	if ($eksekusi) {
		$_SESSION['pesan'] = "Berhasil! Data produk telah diperbarui.";
		$_SESSION['tipe'] = "success";
		header("Location: ../produk.php");
		exit;
	} else {
		$_SESSION['pesan'] = "Gagal memperbarui data! Error: " . mysqli_error($conn);
		$_SESSION['tipe'] = "danger";
		header("Location: ../edit_produk.php?id=$id_product");
		exit;
	}
} else {
	// Jika diakses langsung tanpa lewat form
	header("Location: ../produk.php");
	exit;
}
