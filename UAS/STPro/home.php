<?php
session_start(); // Mulai session

// Sertakan file koneksi database
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // Jika belum login, arahkan kembali ke halaman login
  header("Location: login.php");
  exit();
}

// Ambil data untuk ditampilkan di dashboard
$total_produk = 0;
$total_kategori = 0;
$total_supplier = 0;

// Query untuk menghitung total produk
$query_produk = "SELECT COUNT(*) AS total FROM produk";
$result_produk = mysqli_query($koneksi, $query_produk);
if ($result_produk) {
  $row_produk = mysqli_fetch_assoc($result_produk);
  $total_produk = $row_produk['total'];
}

// Query untuk menghitung total kategori
$query_kategori = "SELECT COUNT(*) AS total FROM kategori";
$result_kategori = mysqli_query($koneksi, $query_kategori);
if ($result_kategori) {
  $row_kategori = mysqli_fetch_assoc($result_kategori);
  $total_kategori = $row_kategori['total'];
}

// Query untuk menghitung total supplier
$query_supplier = "SELECT COUNT(*) AS total FROM supplier";
$result_supplier = mysqli_query($koneksi, $query_supplier);
if ($result_supplier) {
  $row_supplier = mysqli_fetch_assoc($result_supplier);
  $total_supplier = $row_supplier['total'];
}

// Tutup koneksi setelah selesai mengambil data
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
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="js/select.dataTables.min.css">
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
            <div class="border img-ss rounded-circle bg-light me-3"></div>Light
          </div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme">
            <div class="border img-ss rounded-circle bg-dark me-3"></div>Dark
          </div>
          <p class="mt-2 settings-heading">HEADER SKINS</p>
          <div class="px-4 mx-0 color-tiles">
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
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                    <div class="row">
                      <div class="col-lg-12 d-flex flex-column">
                        <div class="row">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h1 class="welcome-text">Selamat Datang, <span class="text-black fw-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</h1>
                                    <p class="mb-4"></p>
                                    <h4 class="card-title card-title-dash">Ringkasan Data Toko</h4>
                                    <p class="mb-4"></p>
                                  </div>
                                  <div id="performance-line-legend"></div>
                                </div>
                                <div class="row mt-12">
                                  <div class="col-md-4 mb-3">
                                    <div class="card card-dark-blue text-white">
                                      <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                          <div>
                                            <h6 class="font-weight-normal mb-0">Total Produk</h6>
                                            <h2 class="mb-0"><?php echo $total_produk; ?></h2>
                                          </div>
                                          <i class="mdi mdi-package-variant-closed icon-lg"></i>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4 mb-3">
                                    <div class="card card-dark-blue text-white">
                                      <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                          <div>
                                            <h6 class="font-weight-normal mb-0">Total Kategori</h6>
                                            <h2 class="mb-0"><?php echo $total_kategori; ?></h2>
                                          </div>
                                          <i class="mdi mdi-package-variant-closed icon-lg"></i>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4 mb-3">
                                    <div class="card card-dark-blue text-white">
                                      <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                          <div>
                                            <h6 class="font-weight-normal mb-0">Total Supplier</h6>
                                            <h2 class="mb-0"><?php echo $total_supplier; ?></h2>
                                          </div>
                                          <i class="mdi mdi-package-variant-closed icon-lg"></i>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>