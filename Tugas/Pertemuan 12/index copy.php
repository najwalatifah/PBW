<!DOCTYPE html>
<html>
<head>
    <title>Program PHP Soal 1 - 4</title>
</head>
<body>
    <h1>Menu Navigasi</h1>
    <ul>
        <li><a href="?page=soal1">Soal 1 - Jenis Kendaraan (Switch)</a></li>
        <li><a href="?page=soal2">Soal 2 - Bilangan Genap (For)</a></li>
        <li><a href="?page=soal3">Soal 3 - Daftar Hewan (Foreach)</a></li>
        <li><a href="?page=soal4">Soal 4 - Genap atau Ganjil (Ternary)</a></li>
    </ul>

    <hr>

    <?php
    if (isset($_GET['page'])) {
        include $_GET['page'] . '.php';
    } else {
        echo "<p>Silakan pilih soal dari menu di atas.</p>";
    }
    ?>
</body>
</html>
