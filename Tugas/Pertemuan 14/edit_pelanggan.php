<?php
include 'koneksi_db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tidak valid'); window.location='pelanggan.php';</script>";
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM pelanggan WHERE ID = $id");
$pelanggan = $result->fetch_assoc();

if (!$pelanggan) {
    echo "<script>alert('Pelanggan tidak ditemukan'); window.location='pelanggan.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Edit Pelanggan</h3>
    <form action="proses_edit_pelanggan.php" method="POST">
        <input type="hidden" name="id" value="<?= $pelanggan['ID'] ?>">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= $pelanggan['Nama'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="<?= $pelanggan['Alamat'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" value="<?= $pelanggan['Telepon'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="pelanggan.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>

