<!DOCTYPE html>
<html>
<head>
    <title>Diskon Pembayaran Mahasiswa</title>
</head>
<body>

<h2>Form Diskon Pembayaran Mahasiswa</h2>
<form method="post" action="">
    NPM: <input type="text" name="npm"><br><br>
    Nama: <input type="text" name="nama"><br><br>
    Prodi: <input type="text" name="prodi"><br><br>
    Semester: <input type="number" name="semester"><br><br>
    Biaya UKT (Rp): <input type="number" name="ukt"><br><br>
    <input type="submit" name="submit" value="Proses">
</form>

<?php
if (isset($_POST['submit'])) {
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $semester = $_POST['semester'];
    $ukt = $_POST['ukt'];

    // Menentukank diskon
    if ($ukt >= 5000000 && $semester > 8) {
        $diskon_persen = 15;
    } elseif ($ukt >= 5000000) {
        $diskon_persen = 10;
    } else {
        $diskon_persen = 0;
    }

    // Hitung jumlah yang harus dibayar
    $jumlah_diskon = ($diskon_persen / 100) * $ukt;
    $total_bayar = $ukt - $jumlah_diskon;

    // Tampilkan hasil
    echo "<h3>Output:</h3>";
    echo "NPM : " . htmlspecialchars ($npm) . "<br>";
    echo "NAMA : " . htmlspecialchars (strtoupper($nama)) . "<br>";
    echo "PRODI : " . htmlspecialchars (strtoupper($prodi)) . "<br>";
    echo "SEMESTER : " . htmlspecialchars ($semester) . "<br>";
    echo "DISKON : " . $diskon_persen . "%<br>";
    echo "YANG HARUS DIBAYAR : Rp. " . number_format($total_bayar, 0, ',', '.');
}

?>

</body>
</html>