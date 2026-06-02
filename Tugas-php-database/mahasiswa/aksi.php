<?php
include_once('koneksi.php');

if (isset($_POST['proses']) && $_POST['proses'] == "simpan") {

	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$web = $_POST['web'];
	$alamat = $_POST['alamat'];

	simpan_data($mysqli, $nama, $email, $web, $alamat);
} elseif (isset($_GET['proses']) && $_GET['proses'] == "hapus") {

	$kode = $_GET['kode'];
	hapus_data($mysqli, $kode);
} elseif (isset($_POST['proses']) && $_POST['proses'] == "update") {

	$kode = $_POST['kode'];
	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$web = $_POST['web'];
	$alamat = $_POST['alamat'];

	update_data($mysqli, $kode, $nama, $email, $web, $alamat);
}
function simpan_data($mysqli, $nama, $email, $web, $alamat)
{
	$query = "INSERT INTO mahasiswa(nama, email, web, alamat)
VALUES('$nama', '$email', '$web', '$alamat')";

	$eksekusi = mysqli_query($mysqli, $query);

	if ($eksekusi) {
		header("Location: data_mahasiswa.php");
		exit;
	} else {
		echo "Proses Input Gagal: " . mysqli_error($mysqli);
	}

	return $eksekusi;
}

function hapus_data($mysqli, $kode)
{
	$sql = "DELETE FROM mahasiswa where kode = '$kode'";
	$eksekusi = $mysqli->query($sql);

	if ($eksekusi) {
		header("Location: data_mahasiswa.php");
		exit;
	} else {
		echo "Proses Hapus Gagal: " . mysqli_error($mysqli);
	}

	return $eksekusi;
}

function update_data($mysqli, $kode, $nama, $email, $web, $alamat)
{
	$sql = "UPDATE mahasiswa SET
			nama='$nama',
			email='$email',
			web='$web',
			alamat='$alamat'
			WHERE kode='$kode'";

	$eksekusi = $mysqli->query($sql);

	if ($eksekusi) {
		header("Location:data_mahasiswa.php");
		exit;
	} else {
		echo "Proses Update Gagal";
	}
}
