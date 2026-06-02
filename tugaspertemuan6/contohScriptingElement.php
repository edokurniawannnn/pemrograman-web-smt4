<?php
function ketiga()
{
	$hitung  = 4 + 7;
	return $hitung;
}

echo (ketiga());

function keempat($sisi)
{
	$luas_persegi = $sisi * $sisi;
	return $luas_persegi;
} ?>

<?= keempat(4) ?>