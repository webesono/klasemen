<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    <?= $title ?>
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="<?php echo base_url() ?>assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?php echo base_url() ?>assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <script src="<?= base_url('assets/js/fontawesome/all.js') ?>" crossorigin="anonymous"></script>
  <link href="<?php echo base_url() ?>assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="<?php echo base_url() ?>assets/css/datatables.min.css" rel="stylesheet" />
  <link id="pagestyle" href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
  <link id="pagestyle" href="<?php echo base_url() ?>assets/css/soft-ui-dashboard.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/css/responsive.css'); ?>" />
  <!-- CSS Materi -->

  <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>

  <head>

  <body class="g-sidenav-show bg-white">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 my-3 fixed-start ms-3 " id="sidenav-main">
      <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand d-flex justify-content-center " href="<?= base_url() ?>" target="_blank">
          <img src="<?= base_url() ?>assets/assets/images.png" class="" style="aspect-ratio: 1:1;" alt="main_logo">
        </a>
      </div>
      <hr class="horizontal dark mt-0">
      <div class="collapse navbar-collapse h-auto w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <?php foreach ($menu as $m) : ?>
            <li class="nav-item">
              <a class="nav-link <?= ($m['url'] == $url) ? 'active' : ''; ?>" href="<?php echo base_url($m['url']) ?>">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">

                  <i class="fa-solid <?= $m['icon'] ?> <?= ($m['url'] == $url) ? 'text-white' : 'text-secondary'; ?>"></i>
                </div>
                <span class="nav-link-text ms-1"><?= ucwords($m['title']) ?></span>
              </a>
            </li>
          <?php endforeach ?>
        </ul>
      </div>
      <!-- <a class="list-style-none py-1 px-3 rounded-2 text-white" style="background-color: #D03824; display: inline-block; margin-left: 33px; margin-top: 20px;">Keluar</a> -->
    </aside>