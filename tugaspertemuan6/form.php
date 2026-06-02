<!DOCTYPE html>
<html>

<head>
	<title>Form Input Data</title>
</head>

<body>
	<h3>Form Input Data Mahasiswa</h3>
	<!-- Sesuai petunjuk: action="aksi.php" method="POST" -->
	<form action="aksi.php" method="POST">
		<label>Nama :</label><br>
		<input type="text" name="nama" size="50" value="24081010064_Cindy Triana" required><br><br>

		<label>Email :</label><br>
		<input type="text" name="email" size="50" value="24081010064@student.upnjatim.ac.id" required><br><br>

		<label>Web :</label><br>
		<input type="text" name="web" size="40" placeholder="www.cindyee.com" required><br><br>

		<label>Alamat :</label><br>
		<textarea name="alamat" rows="5" cols="50" required>sampetua</textarea><br><br>

		<!-- Sesuai petunjuk: name="proses" value="Simpan" -->
		<input type="submit" name="proses" value="Simpan">
		<input type="reset" value="Reset">
	</form>
</body>

</html>