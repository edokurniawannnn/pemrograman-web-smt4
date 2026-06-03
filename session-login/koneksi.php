<?php

$host = "localhost";
$username = "root";
$password = "";
$database  = "pemweb_session_login";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
	die("Koneksi Gagal" . mysqli_connect_error());
}
