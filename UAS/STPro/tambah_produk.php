<?php
session_start(); // Mulai session

include 'koneksi.php'; // Sertakan file koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit();
}

// Inisialisasi variabel untuk pesan feedback
$success_message = '';
$error_message = '';

// Ambil pesan dari session jika ada (dari proses_tambah_produk.php)
if (isset($_SESSION['success_message'])) {
  $success_message = $_SESSION['success_message'];
  unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
  $error_message = $_SESSION['error_message'];
  unset($_SESSION['error_message']);
}

// Ambil data kategori dari database
$kategori_data = [];
$query_kategori = "SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori ASC";
$result_kategori = mysqli_query($koneksi, $query_kategori);
if ($result_kategori) {
  while ($row = mysqli_fetch_assoc($result_kategori)) {
    $kategori_data[] = $row;
  }
} else {
  $error_message .= "Gagal mengambil data kategori: " . mysqli_error($koneksi) . "<br>";
}

// Ambil data supplier dari database
$supplier_data = [];
$query_supplier = "SELECT id_supplier, nama_supplier FROM supplier ORDER BY nama_supplier ASC";
$result_supplier = mysqli_query($koneksi, $query_supplier);
if ($result_supplier) {
  while ($row = mysqli_fetch_assoc($result_supplier)) {
    $supplier_data[] = $row;
  }
} else {
  $error_message .= "Gagal mengambil data supplier: " . mysqli_error($koneksi) . "<br>";
}
mysqli_close($koneksi);
?>

<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>StoreManager </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
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
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Produk Baru</h4>
                  <form class="action-sample" method="post" action="proses_tambah_produk.php">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control form-control-lg" name="nama_produk" id="nama_produk" placeholder="masukan nama produk" required>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>ID Kategori</label>
                        <select class="form-select form-control-lg" name="id_kategori" id="id_kategori" required>
                          <option value="">Pilih Kategori</option>
                          <?php foreach ($kategori_data as $kategori): ?>
                            <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control form-control-lg" id="stok" name="stok" placeholder="Jumlah Stok" min="0" required>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>ID Supplier</label>
                        <select class="form-select form-control-lg" name="id_supplier" id="id_supplier" required>
                          <option value="">Pilih Supplier</option>
                          <?php foreach ($supplier_data as $supplier): ?>
                            <option value="<?php echo $supplier['id_supplier']; ?>"><?php echo $supplier['nama_supplier']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control form-control-lg" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi Produk"></textarea>
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control form-control-lg" id="harga" name="harga" placeholder="Harga Produk" min="0" required>
                      </div>
                      <button type="submit" name="create" class="btn btn-primary me-2">Tambah Barang</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
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
  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="vendors/select2/select2.min.js"></script>
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
  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
  <!-- End custom js for this page-->
</body>

</html>