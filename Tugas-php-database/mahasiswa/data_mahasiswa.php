<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Data Mahasiswa</title>
</head>

<body>
	<h1><a href="form.php">Add</a></h1>
	<table width="513" border="0" align="center">
		<tr bgcolor="#ffffcc">
			<td width="100">Nama</td>
			<td width="100">Email</td>
			<td width="75">Web</td>
			<td width="135">Alamat</td>
			<td colspan="2"></td>
		</tr>
		<?php
		include_once 'koneksi.php';
		$query = "SELECT * FROM mahasiswa";
		$result = $mysqli->query($query);
		if ($result->num_rows > 0) {
			while ($data = $result->fetch_assoc()) {
		?>
				<tr>
					<td><?= $data['nama']; ?></td>
					<td><?= $data['email']; ?></td>
					<td><?= $data['web']; ?></td>
					<td><?= $data['alamat']; ?></td>
					<td width="43">
						<div class="" align="center">
							<a href="form.php?kode=<?= $data['kode'] ?>">edit</a>
						</div>
					</td>
					<td width="43">
						<div align="center">
							<a href="aksi.php?kode=<?= $data['kode']; ?>&proses=hapus"
								onclick="return confirm('Yakin Ingin Menghapus?')">
								hapus
							</a>
						</div>
					</td>
				</tr>
		<?php }
		} ?>
	</table>
</body>

</html>