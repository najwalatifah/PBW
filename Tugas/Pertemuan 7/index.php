<!DOCTYPE html>
<html>
<head>
    <title>Perhitungan Total Pembelian (Dengan Array)</title>
    <style>
        .box {
            border: 1px solid black;
            padding: 15px;
            width: fit-content;
            font-family: Arial, sans-serif;
            margin-top: 20px;
        }
        h2 {
            margin: 0;
        }
    </style>
</head>
<body>

<form method="post">
    <label for="barang">Pilih Nama Barang:</label>
    <select name="barang" required>
        <option value="">-- Pilih Barang --</option>
        <option value="Keyboard">Keyboard</option>
        <option value="Mouse">Mouse</option>
        <option value="Speaker">Speaker</option>
        <option value="Charger">Charger</option>
        <option value="Earphone">Earphone</option>
    </select><br><br>

    <label for="jumlah">Jumlah Beli:</label>
    <input type="number" name="jumlah" min="1" required><br><br>

    <button type="submit">Hitung</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Array harga barang
    $daftarHarga = [
        "Keyboard" => 150000,
        "Mouse" => 50000,
        "Speaker" => 70000,
        "Charger" => 100000,
        "Earphone" => 60000
    ];

    // Ambil data dari form
    $namaBarang = $_POST['barang'];
    $jumlahBeli = $_POST['jumlah'];

    // Cek jika barang tersedia dalam array
    if (array_key_exists($namaBarang, $daftarHarga)) {
        define("PAJAK", 0.10); // Pajak 10%
        $hargaSatuan = $daftarHarga[$namaBarang];
        $totalSebelumPajak = $hargaSatuan * $jumlahBeli;
        $pajak = $totalSebelumPajak * PAJAK;
        $totalBayar = $totalSebelumPajak + $pajak;

        // Tampilkan hasil
        echo "<div class='box'>";
        echo "<h2><b>Perhitungan Total Pembelian (Dengan Array)</b></h2>";
        echo "<hr>";
        echo "<p>Nama Barang: $namaBarang</p>";
        echo "<p>Harga Satuan: Rp " . number_format($hargaSatuan, 0, ',', '.') . "</p>";
        echo "<p>Jumlah Beli: $jumlahBeli</p>";
        echo "<p>Total Harga (Sebelum Pajak): Rp " . number_format($totalSebelumPajak, 0, ',', '.') . "</p>";
        echo "<p>Pajak (10%): Rp " . number_format($pajak, 0, ',', '.') . "</p>";
        echo "<p><b>Total Bayar: Rp " . number_format($totalBayar, 0, ',', '.') . "</b></p>";
        echo "</div>";
    } else {
        echo "<p>Barang tidak ditemukan!</p>";
    }
}
?>

</body>
</html>
