<?php
class cobaPertama
{
	public $salam;
	public $cetak;
	public $alamat = "UPN Veteran Jawa Timur";

	function __construct()
	{
		$this->salam = "Hallo Sobat, Mari Belajar OOP yuk!!";
		echo $this->salam;
	}

	public function cetak_nama($nim, $nama, $kelas)
	{
		$this->cetak = "<br> Nim : " . $nim . "<br> Nama : " . $nama . "<br> Kelas :" . $kelas;
		echo $this->cetak;
	}

	function __destruct()
	{
		$this->salam = "Sudah Selesai Belajarnya, selamat tinggal";
		echo $this->salam;
	}
}
