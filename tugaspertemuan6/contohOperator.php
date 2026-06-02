<?php
//Operator Matematika
$jumlah_barang = 90;
$harga_satuan = 1000;
$terjual = 30;
$total_pendapatan = $terjual * $harga_satuan;
$sisa_barang = $jumlah_barang - $terjual;

echo ("Jumlah Barang : " . $jumlah_barang . "<br>");
echo ("Terjual : " . $terjual . "<br>");
echo ("Total Pendapatan : " . $total_pendapatan . "<br>");
echo ("Sisa Barang : " . $sisa_barang . "<br>");
