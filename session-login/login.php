<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Form Login</title>
</head>

<body>
	<h2>Form Login</h2>
	<form action="aksi.php" method="POST">
		<table>
			<tr>
				<td>Username</td>
				<td>
					<input type="text" name="username">
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>
					<input type="password" name="password">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="proses" value="login">
				</td>
			</tr>
		</table>
	</form>
</body>

</html>