<?php
include 'koneksi_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    $stmt = $conn->prepare("INSERT INTO Pelanggan (Nama, Alamat, Telepon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $alamat, $telepon);

    if ($stmt->execute()) {
        echo "<script>alert('Pelanggan berhasil ditambahkan!'); window.location.href = 'tambah_pelanggan.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pelanggan: " . addslashes($stmt->error) . "');</script>";
    }
}
?>
