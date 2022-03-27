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
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css?v=202203251513'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fontawesome-5.15.4/css/all.min.css'); ?>">

    <!-- Year picker plugin-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/date-time-picker/build/css/bootstrap-datetimepicker.min.css'); ?>">

    <!-- Jquery ui -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/jquery-ui-1.13.0/css/jquery-ui.min.css'); ?>">
</head>

<body>
    <div id="wrapper">
        <!-- Content Wrapper-->
        <div class="d-flex" id="content-wrapper">

            <!-- Sidebar -->
            <ul class="nav navbar-light bg-white sidebar flex-column" id="sidebarMenu">
                <a href="<?php echo base_url('auth'); ?>" class="d-flex sidebar-brand align-items-center justify-content-center fa fa-e"><span>itraWeb</span></a>
                <!-- <img src="<?php echo base_url('assets/images/brand/mitra-logo.png'); ?>" class="img-fluid" alt="mitraLogo"> -->
                <!-- <hr class="sidebar-divider my-0"> -->
                <?= $menu; ?>
            </ul>
            <!-- End of Sidebar -->