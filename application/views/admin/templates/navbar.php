  <main class="main-content position-relative max-height-vh-100 h-100 ">
    <link id="pagestyle" href="<?= base_url('assets/css/responsive.bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-0  shadow-none" id="navbarBlur" navbar-scroll="true" style="flex-direction:column; align-items:flex-start;  ">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active2" aria-current="page"><?= $title ?></li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0"><?= $title ?></h6>
        </nav>

        <div class=" mt-sm-0 mt-2 me-md-0 me-sm-0" id="navbar" style="margin-top: 0px;">
          <div class="ms-md-auto pe-md-0 d-flex align-items-center" style="float: right;">
            <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
              <!-- <image src="<?php echo base_url() ?>assets/assets/img/profile/user-circle.svg"> -->
              <!-- <span class="d-sm-inline text-white d-none"><?= $user['name'] ?> </span> -->
            </a>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </div>
        </div>


      </div>
      <div style="padding-left:13px;">
        <h3 style="color: #FFBC10;"><?= $sub_title ?></h3>
      </div>

    </nav>
    <!-- Akhir Navbar -->
    <!-- End Navbar -->

    <!-- Jquery DataTable -->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/datatables.min.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.dataTables.min.js"></script>