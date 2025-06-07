<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pelanggan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Tambah Pelanggan</h2>
    <form method="post" action="proses_tambah_pelanggan.php">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" class="form-control" name="telepon">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</body>
</html>
