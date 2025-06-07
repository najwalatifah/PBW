<!DOCTYPE html>
<html>
<head>
    <title>Program PHP Soal 1 - 2</title>
</head>
<body>
    <h1>Menu Navigasi</h1>
    <ul>
        <li><a href="?page=nilai_latihan">Soal 1 - Nilai latihan </a></li>
        <li><a href="?page=UKT">Soal 2 - Form pembayaran mahasiswa </a></li>
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