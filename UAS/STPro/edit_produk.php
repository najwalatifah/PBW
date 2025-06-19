<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$success_message = '';
$error_message = '';

// Mengambil pesan dari session jika ada (dari proses_edit_produk.php)
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

$produk_data = null; // Variabel untuk menyimpan data produk yang akan diedit
$id_produk = null;

// Pastikan ada ID produk yang dikirim via GET
if (isset($_GET['id'])) {
    $id_produk = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query hanya mengambil kolom yang ada di database Anda
    // Pastikan tidak ada 'gambar_produk' di sini
    $query_get_produk = "SELECT id_produk, nama_produk, id_kategori, id_supplier, stok, harga, deskripsi FROM produk WHERE id_produk = ?";
    $stmt_get_produk = mysqli_prepare($koneksi, $query_get_produk);
    mysqli_stmt_bind_param($stmt_get_produk, "i", $id_produk);
    mysqli_stmt_execute($stmt_get_produk);
    $result_get_produk = mysqli_stmt_get_result($stmt_get_produk);

    if (mysqli_num_rows($result_get_produk) === 1) {
        $produk_data = mysqli_fetch_assoc($result_get_produk);
    } else {
        $_SESSION['error_message'] = "Produk tidak ditemukan atau ID produk tidak valid.";
        header("Location: daftar_produk.php");
        exit();
    }
    mysqli_stmt_close($stmt_get_produk);
} else {
    $_SESSION['error_message'] = "ID produk tidak disediakan.";
    header("Location: daftar_produk.php");
    exit();
}

// Ambil data kategori dan supplier untuk dropdown
$kategori_data = [];
$query_kategori = "SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori ASC";
$result_kategori = mysqli_query($koneksi, $query_kategori);
if ($result_kategori) {
    while ($row = mysqli_fetch_assoc($result_kategori)) {
        $kategori_data[] = $row;
    }
}

$supplier_data = [];
$query_supplier = "SELECT id_supplier, nama_supplier FROM supplier ORDER BY nama_supplier ASC";
$result_supplier = mysqli_query($koneksi, $query_supplier);
if ($result_supplier) {
    while ($row = mysqli_fetch_assoc($result_supplier)) {
        $supplier_data[] = $row;
    }
}

mysqli_close($koneksi);
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>StoreManager - Edit Produk</title>
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/typicons/typicons.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="images/favicon.png" />
    </head>

<body>
    <div class="container-scroller">
        <nav class="flex-row p-0 navbar default-layout col-lg-12 col-12 fixed-top d-flex align-items-top">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="home.php">
                        <img src="images/logo.svg" alt="logo" />
                    </a>
                    <a class="navbar-brand brand-logo-mini" href="home.php">
                        <img src="images/favicon.png" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text">Selamat Datang, <span class="text-black fw-bold"> <?php echo htmlspecialchars($_SESSION['username']); ?></span> </h1>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border me-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border me-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-category">Dashboard</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="mdi mdi-grid-large menu-icon"></i>
                            <span class="menu-title">Menu</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="home.php">HOME</a></li>
                                <li class="nav-item"> <a class="nav-link" href="daftar_produk.php">Daftar Produk</a></li>
                                <li class="nav-item"> <a class="nav-link" href="tambah_produk.php">Tambah Produk</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Edit Produk</h4>
                                    <?php if (!empty($success_message)) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $success_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($error_message)) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($produk_data) : ?>
                                        <form class="forms-sample" method="post" action="proses_edit_produk.php">
                                            <input type="hidden" name="id_produk" value="<?php echo htmlspecialchars($produk_data['id_produk']); ?>">
                                            <div class="form-group">
                                                <label for="nama_produk">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk" value="<?php echo htmlspecialchars($produk_data['nama_produk']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_kategori">Kategori</label>
                                                <select class="form-control" id="id_kategori" name="id_kategori" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    <?php foreach ($kategori_data as $kategori) : ?>
                                                        <option value="<?php echo htmlspecialchars($kategori['id_kategori']); ?>" <?php echo ($kategori['id_kategori'] == $produk_data['id_kategori']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_supplier">Supplier</label>
                                                <select class="form-control" id="id_supplier" name="id_supplier" required>
                                                    <option value="">-- Pilih Supplier --</option>
                                                    <?php foreach ($supplier_data as $supplier) : ?>
                                                        <option value="<?php echo htmlspecialchars($supplier['id_supplier']); ?>" <?php echo ($supplier['id_supplier'] == $produk_data['id_supplier']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($supplier['nama_supplier']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="stok">Stok</label>
                                                <input type="number" class="form-control" id="stok" name="stok" placeholder="Jumlah Stok" value="<?php echo htmlspecialchars($produk_data['stok']); ?>" min="0" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga (Rp)</label>
                                                <input type="number" step="0.01" class="form-control" id="harga" name="harga" placeholder="Harga Produk" value="<?php echo htmlspecialchars($produk_data['harga']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi Produk</label>
                                                <textarea class="form-control form-control-lg" id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi lengkap produk"><?php echo htmlspecialchars($produk_data['deskripsi']); ?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success me-2">Update Produk</button>
                                            <a href="daftar_produk.php" class="btn btn-dark">Batal</a>
                                        </form>
                                    <?php else : ?>
                                        <div class="alert alert-warning" role="alert">
                                            Produk tidak ditemukan atau ID produk tidak valid.
                                        </div>
                                        <a href="daftar_produk.php" class="btn btn-primary">Kembali ke Daftar Produk</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-center text-muted text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date('Y'); ?>. StoreManager. All rights reserved.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    </body>

</html>
}