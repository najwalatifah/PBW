<?php
session_start(); // Mulai session

// Sertakan file koneksi database
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Inisialisasi variabel untuk pesan feedback
$success_message = '';
$error_message = '';

// Ambil pesan dari session jika ada (dari proses_produk.php atau edit_produk.php)
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Query untuk mengambil semua data produk beserta nama kategori dan supplier
$query_produk = "SELECT
                    p.id_produk,
                    p.nama_produk,
                    k.nama_kategori,
                    s.nama_supplier,
                    p.stok,
                    p.harga,
                    p.deskripsi,
                    p.tanggal_ditambahkan
                 FROM
                    produk p
                 LEFT JOIN
                    kategori k ON p.id_kategori = k.id_kategori
                 LEFT JOIN
                    supplier s ON p.id_supplier = s.id_supplier
                 ORDER BY
                    p.tanggal_ditambahkan DESC";

$result_produk = mysqli_query($koneksi, $query_produk);

$daftar_produk = [];
if ($result_produk) {
    while ($row = mysqli_fetch_assoc($result_produk)) {
        $daftar_produk[] = $row;
    }
} else {
    $error_message .= "Gagal mengambil data produk: " . mysqli_error($koneksi) . "<br>";
}

mysqli_close($koneksi);
?>

<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>StoreManager</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="flex-row p-0 navbar default-layout col-lg-12 col-12 fixed-top d-flex align-items-top">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="home.php">
            <img src="SM.svg" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="home.php">
            <img src="SM.svg" alt="logo" />
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold"> <?php echo $_SESSION['username']; ?></span> </h1>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <a class="nav-link" href="proses_logout.php">Logout</a>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
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
      <!-- partial:partials/_sidebar.html -->
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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Produk</h4>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Nama Produk</th>
                          <th>Kategori</th>
                          <th>Supplier</th>
                          <th>Stok</th>
                          <th>Harga</th>
                          <th>Deskripsi</th>
                          <th>Tanggal Ditambahkan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (count($daftar_produk) > 0) : ?>
                          <?php foreach ($daftar_produk as $produk) : ?>
                            <tr>
                              <td><?php echo htmlspecialchars($produk['nama_produk']); ?></td>
                              <td><?php echo htmlspecialchars($produk['nama_kategori']); ?></td>
                              <td><?php echo htmlspecialchars($produk['nama_supplier']); ?></td>
                              <td><label class="badge <?php echo ($produk['stok'] > 0) ? 'badge-success' : 'badge-danger'; ?>"><?php echo htmlspecialchars($produk['stok']); ?></label></td>
                              <td>$ <?php echo number_format($produk['harga'], 2, ',', '.'); ?></td>
                              <td><?php echo htmlspecialchars(substr($produk['deskripsi'], 0, 50)); ?>...</td>
                              <td><?php echo date('d M Y H:i', strtotime($produk['tanggal_ditambahkan'])); ?></td>
                              <td>
                                <a href="edit_produk.php?id=<?php echo htmlspecialchars($produk['id_produk']); ?>" class="btn btn-sm btn-info me-2">Edit</a>
                                <a href="proses_produk.php?action=delete&id=<?php echo htmlspecialchars($produk['id_produk']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else : ?>
                          <tr>
                            <td colspan="9" class="text-center">Tidak ada produk ditemukan.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>