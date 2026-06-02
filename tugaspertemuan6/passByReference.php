<?php
$nama = "Masukkan Nama Anda";
function bkn_reference($nama)
{
	$nama .= " Memang Tidak Gawull";
	echo ("<br>" . $nama);
}

bkn_reference($nama);
echo ("Kata Tidak Gawull Hilang ===>" . $nama);

function reference(&$nama)
{
	$nama .= " Memang Paling Gawull";
	echo ("<br><br>" . $nama);
}
reference($nama);
echo ("<br> Kata Tidak Gawull Masih ===>" . $nama);
