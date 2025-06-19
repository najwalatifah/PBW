<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $id_supplier = mysqli_real_escape_string($koneksi, $_POST['id_supplier']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Query untuk menyimpan data produk ke database
    $query = "INSERT INTO produk (nama_produk, id_kategori, id_supplier, stok, harga, deskripsi) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);

    if ($stmt) {
        // "ssiisss" -> s: string, i: integer, d: double/decimal
        mysqli_stmt_bind_param($stmt, "siisds", $nama_produk, $id_kategori, $id_supplier, $stok, $harga, $deskripsi);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Produk berhasil ditambahkan!";
        } else {
            $_SESSION['error_message'] = "Gagal menambahkan produk: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = "Error prepared statement: " . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
    header("Location: daftar_produk.php"); // Redirect kembali ke halaman tambah_produk.php
    exit();

} else {
    // Jika diakses langsung tanpa POST request, redirect kembali
    header("Location: tambah_produk.php");
    exit();
}
?>