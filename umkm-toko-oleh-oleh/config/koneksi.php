<?php
session_start();
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_toko_oleh_oleh';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
	die("Koneksi gagal: " . mysqli_connect_error());
}
