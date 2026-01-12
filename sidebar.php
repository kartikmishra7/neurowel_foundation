<?php
// sidebar.php

// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// Relative path calculation
$includer_dir = realpath(dirname($_SERVER['SCRIPT_FILENAME']));
$root_dir = realpath(dirname(__FILE__));

$relative_path = '';
if ($includer_dir && $root_dir && $includer_dir != $root_dir) {
    $includer_parts = explode(DIRECTORY_SEPARATOR, $includer_dir);
    $root_parts = explode(DIRECTORY_SEPARATOR, $root_dir);

    $i = 0;
    while ($i < count($includer_parts) && $i < count($root_parts) && $includer_parts[$i] === $root_parts[$i]) {
        $i++;
    }

    $depth = count($includer_parts) - $i;
    if ($depth > 0) {
        $relative_path = str_repeat('../', $depth);
    }
}

$relative_path = str_replace('\\', '/', $relative_path);
?>

<div class="sidebar">
    <h5 class="text-white mb-4"><i class="bi bi-heart-fill"></i> Neurowel</h5>

    <!-- Dashboard -->
    <a href="<?= $relative_path ?>index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <!-- Users -->
    <a href="<?= $relative_path ?>users.php" class="<?= $current_page == 'users.php' ? 'active' : '' ?>">
        <i class="bi bi-people"></i> Users
    </a>

    <!-- CMS Dropdown -->
    <a href="#cmsSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="bi bi-layout-text-window"></i> CMS
    </a>
    <ul class="collapse list-unstyled <?= strpos($current_page, 'view') !== false || strpos($current_page, 'gallery') !== false || strpos($current_page, 'get_involved') !== false ? 'show' : '' ?>" id="cmsSubmenu">
        <li>
            <a href="<?= $relative_path ?>cms/homepage/veiw.php" class="sub-link <?= $current_page == 'veiw.php' ? 'active' : '' ?>">Home Page</a>
        </li>
        <li>
            <a href="<?= $relative_path ?>cms/view_about.php" class="sub-link <?= $current_page == 'view_about.php' ? 'active' : '' ?>">About Page</a>
        </li>
        <li>
            <a href="<?= $relative_path ?>cms/what we do/view.php" class="sub-link <?= $current_page == 'view.php' ? 'active' : '' ?>">What We Do</a>
        </li>
        <li>
            <a href="<?= $relative_path ?>cms/our impact/view.php" class="sub-link <?= $current_page == 'view.php' ? 'active' : '' ?>">Our Impact</a>
        </li>
        <li>
            <a href="<?= $relative_path ?>cms/gallery/gallery_admin.php" class="sub-link <?= $current_page == 'gallery_admin.php' ? 'active' : '' ?>">Gallery</a>
        </li>
        <li>
            <a href="<?= $relative_path ?>cms/contact/veiw.php" class="sub-link <?= $current_page == 'veiw.php' ? 'active' : '' ?>">Contact</a>
        </li>
        
    </ul>

    <!-- Volunteers -->
    <a href="<?= $relative_path ?>volunteers/volunteer.php" class="<?= $current_page == 'volunteer.php' ? 'active' : '' ?>">
        <i class="bi bi-person-check"></i> Volunteers
    </a>

    <!-- Donations -->
    <a href="<?= $relative_path ?>donations/dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
        <i class="bi bi-cash-stack"></i> Donations
    </a>

    <!-- Reports -->
    <a href="<?= $relative_path ?>reports.php" class="<?= $current_page == 'reports.php' ? 'active' : '' ?>">
        <i class="bi bi-graph-up"></i> Reports
    </a>

    <!-- Settings -->
    <a href="<?= $relative_path ?>settings.php" class="<?= $current_page == 'settings.php' ? 'active' : '' ?>">
        <i class="bi bi-gear"></i> Settings
    </a>

    <hr class="text-white">

    <!-- Logout -->
    <a href="<?= $relative_path ?>logout.php" class="text-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

<!-- Sidebar CSS -->
<style>
body{
    margin:0;
    background:#f4f6f8;
    font-family:'Segoe UI', Arial, sans-serif;
}

.sidebar{
    width:220px;
    min-height:100vh;
    background:#1e3a8a;
    position:fixed;
    left:0;
    top:0;
    padding:20px 10px;
    z-index:1000;
}

.sidebar h5{
    font-weight:600;
}

.sidebar a{
    color:#fff;
    text-decoration:none;
    display:block;
    padding:10px 12px;
    border-radius:8px;
    margin-bottom:6px;
    font-size:14px;
    transition:0.3s;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.2);
}

.sidebar a.active{
    background:#fff;
    color:#1e3a8a;
    font-weight:bold;
}

.sidebar .sub-link{
    padding-left:25px;
    font-size:13px;
    opacity:0.9;
}

.sidebar .sub-link.active{
    background:#fff;
    color:#1e3a8a;
    font-weight:bold;
}

/* Main content spacing */
.main{
    margin-left:240px;
    padding:30px;
}

/* Dropdown caret */
.dropdown-toggle::after{
    float:right;
    margin-top:5px;
    content:"\f078";
    font-family: 'Bootstrap Icons';
}
</style>

<!-- Bootstrap JS for collapse -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
