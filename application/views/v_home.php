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
</head>

<body>
<div id="wrapper">
    <!-- Content Wrapper-->
    <div class="d-flex" id="content-wrapper">
        
        <!-- Sidebar -->
        <ul class="nav navbar-light bg-white sidebar flex-column" id="sidebarMenu">
            <a href="#" class="d-flex sidebar-brand align-items-center justify-content-center fa fa-e"><span>ndemik</span></a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="fas fa-align-justify"></i>
                    <span>Form</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#sidebarMenu" style="">
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

        <!-- Main Content -->
        <div id="main-content-wrapper" class="d-flex flex-column">

            <!-- navbar -->
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                <button class="sidebar-toggler" id="sidebarToggle">
                    <i class="fas fa-angle-double-left"></i>
                </button>
                <button class="navbar-toggler ml-auto" data-toggle="collapse" data-target="#navbarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Products</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Users</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End of Navbar -->

            <!-- container -->
            <!-- <div class="container">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                        <input type="email" class="form-control" id="inputEmail4">
                        </div>
                        <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="inputPassword4">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Address 2</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity">
                        </div>
                        <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                        </div>
                        <div class="form-group col-md-2">
                        <label for="inputZip">Zip</label>
                        <input type="text" class="form-control" id="inputZip">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Check me out
                        </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div> -->
            <!-- End of Container -->

            <!-- Footer -->
            <footer class="navbar bg-dark text-light mt-auto">
                <div class="container">
                    <div class="copyright text-center mx-auto">
                        <span>Copyright © Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content -->
</div>
<!-- End Of Wrapper -->

    <script src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-4.6.1/dist/js/bootstrap.bundle.min.js'); ?>"></script>
    
    <!-- main.js -->
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

</body>

</html>