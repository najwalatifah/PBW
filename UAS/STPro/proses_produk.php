<?php
session_start();
include 'koneksi.php';

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_produk_to_delete = mysqli_real_escape_string($koneksi, $_GET['id']);

    $query_delete = "DELETE FROM produk WHERE id_produk = ?";
    $stmt_delete = mysqli_prepare($koneksi, $query_delete);

    if ($stmt_delete) {
        mysqli_stmt_bind_param($stmt_delete, "i", $id_produk_to_delete);
        if (mysqli_stmt_execute($stmt_delete)) {
           $_SESSION['success_message'] = "Produk berhasil dihapus!";
        } else {
            $_SESSION['error_message'] = "Gagal menghapus produk: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt_delete);
    } else {
        $_SESSION['error_message'] = "Error prepared statement untuk hapus: " . mysqli_error($koneksi);
    }
} else {
    $_SESSION['error_message'] = "Permintaan hapus tidak valid.";
}

mysqli_close($koneksi);
header("Location: daftar_produk.php"); // Redirect kembali ke daftar produk
exit();
?>