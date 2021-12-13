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
                <a href="#" class="nav-link"><?= $this->session->userdata('first_name'); ?></a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Users</a>
            </li>
        </ul>
    </div>
</nav>
<!-- End of Navbar -->