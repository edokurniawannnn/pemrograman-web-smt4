<?php
$hari_sekarang = date("Monday");
switch ($hari_sekarang) {
	case 'Monday':
		$hari = "Senin";
		break;
	case 'Tuesday':
		$hari = "Selasa";
		break;
	case 'Wednesday':
		$hari = "Rabu";
		break;
	case 'Thursday':
		$hari = "Kamis";
		break;
	case 'Friday':
		$hari = "Jumat";
		break;
	case 'Saturday':
		$hari = "Sabtu";
	default:
		$hari = "Minggu";
		break;
}
echo ("Sekarang Adalah Hari " . $hari);
