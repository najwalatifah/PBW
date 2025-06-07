<!DOCTYPE html>
<html>
<head>
    <title>Latihan</title>
</head>
<body>
    <form action="proses.php" method="post">
        //kode proses php
    </form>

    <?php
    if (isset($_POST['submit'])) {
    $var_nama = $_POST['nama'];
    $var_email = $_POST['email'];
    }

    $nilai = 75;
    if ($nilai >= 80) {
    echo "Nilai A";
    } elseif ($nilai >= 70) {
    echo "Nilai B";
    } else {
    echo "Nilai C";
    }

    ?>

</body>
</html>
