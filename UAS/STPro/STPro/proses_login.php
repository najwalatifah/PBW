<?php
session_start(); // Mulai session

include 'koneksi.php'; // Sertakan file koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Melindungi dari SQL Injection (sangat penting!)
    // Gunakan prepared statements
    $stmt = mysqli_prepare($koneksi, "SELECT id, username, password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username); // "s" menunjukkan parameter adalah string
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verifikasi password yang di-hash
        if (password_verify($password, $hashed_password)) {
            // Login berhasil
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            header("Location: home.php"); // Ganti index.php dengan halaman dashboard Anda

            // Redirect ke halaman dashboard atau halaman utama
            exit();
        } else {
            // Password salah
            $_SESSION['error_message'] = "Username atau password salah.";
            header("Location: login.php");
            exit();
        }
    } else {
        // Username tidak ditemukan
        $_SESSION['error_message'] = "Username atau password salah.";
        header("Location: login.php");
        exit();
    }
} else {
    // Jika diakses langsung tanpa POST request, redirect kembali ke login
    header("Location: login.php");
    exit();
}
?>