<?php
$nilaipraktikum_php = 90;
$nilaipraktikum_jarkom = 90;

if ($nilaipraktikum_php > $nilaipraktikum_jarkom) {
	echo ("Praktikum PHP lebih mudah");
} else if ($nilaipraktikum_php == $nilaipraktikum_jarkom) {
	echo ("Praktikum PHP dengan Jarkom tingkat kesulitannya sama");
} elseif ($nilaipraktikum_php < $nilaipraktikum_jarkom) {
	echo ("Praktikum Jarkom lebih mudah");
}
