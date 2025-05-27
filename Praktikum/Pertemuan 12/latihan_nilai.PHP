<!DOCTYPE html>
<html>
<head>
    <title>Latihan Nilai</title>
</head>
<body>
    <h2>Form Input Nilai Mahasiswa</h2>
    <form method="post" action="">
        Nama Mahasiswa: <input type="text" name="nama"><br><br>
        Nilai Ujian: <input type="number" name="nilai"><br><br>
        <input type="submit" name="submit" value="Kirim">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $nilai = $_POST['nilai'];
        $predikat = "";
        $status = "";

        if ($nilai >= 85 && $nilai <= 100) {
            $predikat = "A";
            $status = "Lulus";
        } elseif ($nilai >= 75 && $nilai <= 84) {
            $predikat = "B";
            $status = "Lulus";
        } elseif ($nilai >= 65 && $nilai <= 74) {
            $predikat = "C";
            $status = "Lulus";
        } elseif ($nilai >= 50 && $nilai <= 64) {
            $predikat = "D";
            $status = "Tidak Lulus";
        } elseif ($nilai >= 0 && $nilai <= 49) {
            $predikat = "E";
            $status = "Tidak Lulus";
        } else {
            $predikat = "Tidak valid";
            $status = "Tidak Lulus";
        }

        echo "<h3>Hasil</h3>";
        echo "Nama Mahasiswa: " . htmlspecialchars($nama) . "<br>";
        echo "Nilai Ujian: " . htmlspecialchars($nilai) . "<br>";
        echo "Predikat: " . $predikat . "<br>";
        echo "Status: " . $status;
    }
    ?>
</body>
</html>
