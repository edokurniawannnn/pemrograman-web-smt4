<?php
include_once 'koneksi.php';

$kode   = "";
$nama   = "";
$email  = "";
$web    = "";
$alamat = "";

if (isset($_GET['kode'])) {
	$kode = $_GET['kode'];
	$query = "SELECT * FROM mahasiswa WHERE kode='$kode'";
	$result = $mysqli->query($query);

	if ($result->num_rows > 0) {
		$data = $result->fetch_assoc();

		$kode   = $data['kode'];
		$nama   = $data['nama'];
		$email  = $data['email'];
		$web    = $data['web'];
		$alamat = $data['alamat'];
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Form</title>
</head>

<h2>Form Mahasiswa</h2>
<form action="aksi.php" method="POST">
	<input type="hidden" name="kode" value="<?= $kode; ?>">
	<table>
		<tr>
			<td>Nama</td>
			<td>
				<input type="text" name="nama" value="<?= $nama; ?>">
			</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>
				<input type="email" name="email" value="<?= $email; ?>">
			</td>
		</tr>
		<tr>
			<td>Web</td>
			<td>
				<input type="text" name="web" value="<?= $web; ?>">
			</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>
				<textarea name="alamat"><?= $alamat; ?></textarea>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php
				if (isset($_GET['kode'])) {
				?>
					<input type="submit" name="proses" value="update">
				<?php
				} else {
				?>
					<input type="submit" name="proses" value="simpan">
				<?php
				}
				?>
			</td>
		</tr>
	</table>
</form>
</body>

</html>