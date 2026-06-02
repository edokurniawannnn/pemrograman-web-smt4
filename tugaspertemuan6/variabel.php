<?php
$nama = "Edo Kurniawan"; //Variable dengan tipe data string
$nilai_bhs = 2; //Variable dengan tipe data integer
$nilai_ipa = 2.5; //Variable dengan tipe data double
$bentuk_boolean = true; //Variable dengan tipe data boolean
echo ("Nama Mahasiswa: " . $nama . "<br>");
echo ("Nilai Bahasa: " . $nilai_bhs . "<br>");
echo ("Nilai IPA: " . $nilai_ipa . "<br>");

if ($bentuk_boolean == true) {
	echo ("Boolean Menunjukkan Nilai Benar<br>");
}

$nilai_bhs = (float)$nilai_bhs; // konfersi int -> float
$nilai_ipa = (int)$nilai_ipa; //konfersi double -> int

echo ("Nilai Bahasa setelah dikonfersi float = " . $nilai_bhs . "<br>");
echo ("Nilai Bahasa setelah dikonfersi integer = " . $nilai_ipa . "<br>");
