<?php
$jumlahRoda = 4;

echo "<h2>Soal 1 - Jenis Kendaraan</h2>";
echo "Jumlah roda: $jumlahRoda<br>";
echo "Jenis kendaraan: ";

switch ($jumlahRoda) {
    case 2:
        echo "Motor";
        break;
    case 3:
        echo "Bajaj";
        break;
    case 4:
        echo "Mobil";
        break;
    case 6:
    case 8:
        echo "Truk";
        break;
    default:
        echo "Jenis tidak diketahui";
        break;
}
?>