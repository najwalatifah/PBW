<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Hanya proses jika request adalah POST dan ada ID produk
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_produk'])) {
    $id_produk = mysqli_real_escape_string($koneksi, $_POST['id_produk']);
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $id_supplier = mysqli_real_escape_string($koneksi, $_POST['id_supplier']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $query_update = "UPDATE produk SET nama_produk = ?, id_kategori = ?, id_supplier = ?, stok = ?, harga = ?, deskripsi = ? WHERE id_produk = ?";
    $stmt_update = mysqli_prepare($koneksi, $query_update);

    if ($stmt_update) {
            mysqli_stmt_bind_param($stmt_update, "siisdsi",
            $nama_produk, $id_kategori, $id_supplier, $stok, $harga, $deskripsi, $id_produk
        );

        if (mysqli_stmt_execute($stmt_update)) {
            $_SESSION['success_message'] = "Produk berhasil diperbarui!";
            header("Location: daftar_produk.php"); // Redirect ke daftar produk setelah berhasil update
            exit();
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui produk: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt_update);
    } else {
        $_SESSION['error_message'] = "Error prepared statement untuk update: " . mysqli_error($koneksi);
    }

    // Jika ada error dalam proses POST, redirect kembali ke halaman edit
    header("Location: edit_produk.php?id=" . $id_produk);
    exit();

} else {
    // Jika diakses langsung tanpa POST request atau tanpa id_produk, redirect kembali ke daftar produk
    header("Location: daftar_produk.php");
    exit();
}
?>