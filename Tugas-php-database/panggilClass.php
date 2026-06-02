<?php
require 'cobaClass.php';

$as = new cobaPertama();
$a = $as->alamat;
$isi = $as->cetak_nama('24081010269', 'Edo Kurniawan', $a);

echo ($isi . "<br>");
