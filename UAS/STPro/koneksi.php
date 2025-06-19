<?php

$host = "localhost"; // Ganti jika host database Anda berbeda
$user = "root";      // Ganti dengan username database Anda
$pass = "";          // Ganti dengan password database Anda (biasanya kosong untuk XAMPP/WAMP)
$db   = "toko_produk"; // Nama database yang sudah kita buat

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Opsional: Atur encoding agar mendukung karakter khusus
mysqli_set_charset($koneksi, "utf8");

?>