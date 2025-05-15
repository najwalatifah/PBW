<!DOCKTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pertemuan 7</title>
</head>
<body>
    <?php
        // $nama = "Budi";
        // $umur = 20;
        // Menampilkan nilai variabel
        // echo "Nama: " . $nama . "<br>";
        // echo "Umur: " . $umur . " tahun<br>";

        // define("NAMA_KONSTANTA", nilai);

        // define("SITE_NAME", "unsika.ac.id");
        // define("VERSION", "1.0");

        // echo "Selamat datang di " . SITE_NAME . "<br>";
        // echo "Versi Sistem: " . VERSION . "<br>";

        // $nama = "Andi";
        // echo "Nama saya adalah”. $nama;
        // $umur = 25;
        // echo "Umur saya”. $umur. “tahun";
        // $berat = 55.5;
        // echo "Berat badan saya". $berat ."kg";
        // $isLogin = true;

        // $buah = ["apel", "jeruk", "mangga"];
        // echo $buah[1];

        class Mahasiswa {
            public $nama;
            public function sapa() {
                return "Halo, saya $this->nama";
            }
        }
        $mhs = new Mahasiswa();
        $mhs->nama = "Najwa";
        echo $mhs->sapa();


    ?>
</body>
</html>