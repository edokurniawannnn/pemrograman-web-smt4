<?php
include_once('koneksi.php');

// Cek apakah t
if (isset($_POST['proses'])) {
	// Ambil data dari formulir
	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$web = $_POST['web'];
	$alamat = $_POST['alamat'];

	// Perintah simpan data
	$query = "INSERT INTO mahasiswa (Nama, Email, web, alamat) 
              VALUES ('$nama', '$email', '$web', '$alamat')";

	$eksekusi = $mysqli->query($query);

	if ($eksekusi) {
		echo "<h2 style='color:green;'>✅ Proses Input Berhasil</h2>";
		echo "<p><a href='form.php'>⬅️ Kembali ke Formulir</a></p>";
	} else {
		echo "<h2 style='color:red;'>❌ Proses Input Gagal</h2>";
		echo "<p>Penyebab: " . $mysqli->error . "</p>";
		echo "<p><a href='form.php'>⬅️ Kembali ke Formulir</a></p>";
	}
} else {
	// Kalau dibuka langsung tanpa kirim data
	echo "<h2 style='color:orange;'>⚠️ Silakan isi formulir terlebih dahulu!</h2>";
	echo "<p><a href='form.php'>⬅️ Ke Halaman Formulir</a></p>";
}

$mysqli->close();
