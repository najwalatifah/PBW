<?php include 'koneksi_db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Daftar Pelanggan</h2>
    <a href="tambah_pelanggan.php" class="btn btn-primary mb-3">+ Tambah Pelanggan</a>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Buku</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Nama</th><th>Alamat</th><th>Telepon</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $result = $conn->query("SELECT * FROM pelanggan");
    while ($row = $result->fetch_assoc()):
    ?>
        <tr>
            <td><?= $row['ID'] ?></td>
            <td><?= htmlspecialchars($row['Nama']) ?></td>
            <td><?= htmlspecialchars($row['Alamat']) ?></td>
            <td><?= htmlspecialchars($row['Telepon']) ?></td>
            <td>
                <a href="edit_pelanggan.php?id=<?= $row['ID']; ?>" class="btn btn-warning">Edit</a>
                <a href="proses_hapus.php?id=<?= $row['ID']; ?>" 
                onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');" 
                class="btn btn-danger">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>
</body>
</html>
