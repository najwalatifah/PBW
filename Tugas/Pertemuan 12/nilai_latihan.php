<!DOCTYPE html>
<html>
<head>
    <title>Latihan Nilai</title>
</head>
</body>

<h2>Form Input Nilai Mahasiswa</h2>
<form method="post" action="">
    Nama Mahasiswa: <input type="text" name="nama"><br><br>
    Nilai Ujian: <input type="number" name="nilai"><br><br>
    <input type="submit" name="submit" value="Proses">
</form>

<?php
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nilai = $_POST['nilai'];
    $predikat = "";
    $status = "";

    // Mennetukan predikat dan status
    if ($nilai >= 85 && $nilai <= 100) {
        $predikat = "A";
        $status = "LULUS";
    } elseif ($nilai >= 75 && $nilai <= 84) {
        $predikat = "B";
        $status = "LULUS";
    } elseif ($nilai >= 65 && $nilai <= 74) {
        $predikat = "C";
        $status = "LULUS";
    } elseif ($nilai >= 50 && $nilai <= 64) {
        $predikat = "D";
        $status = "TIDAK LULUS";
    } elseif ($nilai >= 0 && $nilai <= 49) {
        $predikat = "E";
        $status = " TIDAK LULUS";
    } else {
        $predikat = "Tidak Valid";
        $status = "Tidak Valid";
    }

    
    echo "<h3>Hasil:</h3>";
    echo "Nama: " . htmlspecialchars($nama) . "<br>";
    echo "Nilai Ujian: " . htmlspecialchars($nilai) . "<br>";
    echo "Predikat: ". $predikat . "<br>";
    echo "Status: " . $status;
}
?>

</body>
</html>
