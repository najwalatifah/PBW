<!DOCTYPE html>
<html>
    <head>
        <title> Program PHP Soal 1-4 </title>
</head>
<body>
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

<?php
echo "<h2>Soal 2 - Bilangan Genap dari 2 sampai 10</h2>";
for ($i = 2; $i <= 10; $i += 2) {
    echo "$i ";
}
?>



</body>
</html>