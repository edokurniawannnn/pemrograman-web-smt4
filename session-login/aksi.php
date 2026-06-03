<?php
session_start();
include_once 'koneksi.php';

function login($conn, $username, $password)
{
	$sql = "SELECT * FROM user
			WHERE username='$username'
			AND password='$password'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

		$data = $result->fetch_assoc();

		$_SESSION['id'] = $data['id_user'];
		$_SESSION['username'] = $data['username'];

		header("Location: dashboard.php");
		exit;
	} else {

		echo "Username atau Password Salah";
	}
}

function logout()
{
	session_unset();
	session_destroy();

	// header("Location: login.php");
	echo "
	<script>
		alert('Berhasil Logout');
		window.location='login.php';
	</script>
	";
	exit;
}


if (isset($_POST['proses']) && $_POST['proses'] == "login") {

	$username = $_POST['username'];
	$password = $_POST['password'];

	login($conn, $username, $password);
} elseif (isset($_GET['proses']) && $_GET['proses'] == "logout") {

	logout();
}
