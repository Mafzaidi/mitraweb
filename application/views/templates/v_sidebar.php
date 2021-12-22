<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $tittle; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-4.6.1/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/home.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fontawesome-5.15.4/css/all.min.css'); ?>">

    <!-- Year picker plugin-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/date-time-picker/build/css/bootstrap-datetimepicker.min.css'); ?>">
</head>

<body>
    <div id="wrapper">
        <!-- Content Wrapper-->
        <div class="d-flex" id="content-wrapper">

            <!-- Sidebar -->
            <ul class="nav navbar-light bg-white sidebar flex-column" id="sidebarMenu">
                <a href="#" class="d-flex sidebar-brand align-items-center justify-content-center fa fa-e"><span>itraWeb</span></a>
                <!-- <img src="<?php echo base_url('assets/images/brand/mitra-logo.png'); ?>" class="img-fluid" alt="mitraLogo"> -->
                <hr class="sidebar-divider my-0">
                <!-- <?= $menu; ?> -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-align-justify"></i>
                        <span>Form</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#sidebarMenu">
                        <div class="card bg-white py-2 rounded">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <a class="collapse-item" href="#"><i class="fas fa-file-alt"></i><span>Peminjaman Medrec</span></a>
                                </li>
                                <li class="list-group-item">
                                    <a class="collapse-item" href="#"><i class="fas fa-file-alt"></i><span>Pemakaian Alat</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-folder-open"></i>
                        <span>Link</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-folder-open"></i>
                        <span>Link</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-folder-open"></i>
                        <span>Link</span>
                    </a>
                </li>
            </ul>
            <!-- End of Sidebar -->