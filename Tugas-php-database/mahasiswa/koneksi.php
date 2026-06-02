<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "pemweb_tgsdatabase";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_errno) {
	echo "Gagal connect ke mysql" . $mysqli->connect_error;
}
