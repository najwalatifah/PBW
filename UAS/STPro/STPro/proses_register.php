<?php
session_start(); // Mulai session

include 'koneksi.php'; // Sertakan file koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "Semua field harus diisi.";
        header("Location: register.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Konfirmasi password tidak cocok.";
        header("Location: register.php");
        exit();
    }

    // Pastikan username unik
    $stmt_check = mysqli_prepare($koneksi, "SELECT id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        $_SESSION['error_message'] = "Username sudah terdaftar. Silakan gunakan username lain.";
        header("Location: register.php");
        exit();
    }
    mysqli_stmt_close($stmt_check);

    // Hash password sebelum menyimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan data user baru ke database
    $stmt_insert = mysqli_prepare($koneksi, "INSERT INTO users (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt_insert, "ss", $username, $hashed_password);

    if (mysqli_stmt_execute($stmt_insert)) {
        $_SESSION['success_message'] = "Registrasi berhasil! Silakan login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Registrasi gagal. Silakan coba lagi. (" . mysqli_error($koneksi) . ")";
        header("Location: register.php");
        exit();
    }

    mysqli_stmt_close($stmt_insert);
    mysqli_close($koneksi);

} else {
    // Jika diakses langsung tanpa POST request, redirect kembali ke register
    header("Location: register.php");
    exit();
}
?>