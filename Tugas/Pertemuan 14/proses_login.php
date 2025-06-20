<?php
session_start();
include 'koneksi_db.php'; // koneksi menggunakan MySQLi OOP

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek user di database, ambil juga kolom level
    $stmt = $conn->prepare("SELECT id, nama, katasandi, level FROM pengguna WHERE nama = ? AND katasandi = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Simpan data ke session
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['level'] = $user['level']; // Simpan level user
        $_SESSION['login_Un51k4'] = true;

        header("Location: index.php");
        exit;
    } else {
        header("Location: login.php?message=" . urlencode("Password salah broo..."));
        exit;
    }

    $stmt->close();
}
?>
