<?php
class Induk
{
	function fungsiInduk()
	{
		echo "Panggil fungai Induk";
	}
}

class Anak extends Induk
{
	function fungsiAnak()
	{
		echo "<br>Panggil Fungsi Anak";
	}
}
$child = new Anak();
$child->fungsiInduk();
$child->fungsiAnak();
