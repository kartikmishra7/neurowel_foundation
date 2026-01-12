<?php
session_start();
require_once '../../auth.php';

$auth = new Auth();

if (!$auth->check()) {
    header("Location: ../login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "ngo_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//  FETCH DATA FROM CORRECT TABLE
$query  = "SELECT * FROM contact_page ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    die("No data found in table");
}

// Get current page filename for sidebar
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Page Preview</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family: Arial, sans-serif;
    background:#b9bbc0ff;
    padding:0;
}

/* Sidebar Styles */
.sidebar{
    width:260px;
    min-height:100vh;
    background:linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
    position:fixed;
    left:0;
    top:0;
    padding:25px 15px;
    z-index:1000;
    box-shadow:4px 0 20px rgba(0,0,0,0.1);
    overflow-y:auto;
}

.sidebar h5{
    color:#fff;
    font-weight:700;
    font-size:20px;
    margin-bottom:30px;
    padding-bottom:20px;
    border-bottom:2px solid rgba(255,255,255,0.2);
    text-align:center;
}

.sidebar h5 i{
    color:#fbbf24;
    margin-right:8px;
}

.sidebar a{
    color:#e0e7ff;
    text-decoration:none;
    display:flex;
    align-items:center;
    padding:12px 15px;
    border-radius:10px;
    margin-bottom:8px;
    font-size:14px;
    transition:all 0.3s ease;
    font-weight:500;
}

.sidebar a i{
    margin-right:12px;
    font-size:18px;
    width:24px;
    text-align:center;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.15);
    color:#fff;
    transform:translateX(5px);
}

.sidebar a.active{
    background:#fff;
    color:#1e3a8a;
    font-weight:600;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}

.sidebar .sub-link{
    padding-left:45px;
    font-size:13px;
    opacity:0.9;
    margin-left:10px;
}

.sidebar .sub-link.active{
    background:#fff;
    color:#1e3a8a;
    font-weight:600;
}

.sidebar hr{
    border-color:rgba(255,255,255,0.2);
    margin:20px 0;
}

.sidebar .text-danger{
    color:#fca5a5 !important;
}

.sidebar .text-danger:hover{
    background:rgba(239,68,68,0.2) !important;
    color:#fee2e2 !important;
}

/* Collapse Menu */
.collapse{
    margin-top:5px;
}

.collapse.show{
    display:block;
}

.page-wrapper{
    margin-left:280px;
    padding:30px;
    max-width:calc(100% - 280px);
}
.page-title{
    text-align:center;
    color:#2c5aa0;
    margin-bottom:40px;
    font-size:2.5rem;
}
.card{
    background:#fff;
    border-radius:10px;
    padding:30px;
    margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}
.section-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}
.section-header h3{
    color:#2c5aa0;
}
.edit-btn{
    background:#2c5aa0;
    color:#fff;
    padding:8px 20px;
    border-radius:5px;
    text-decoration:none;
}
.text{
    margin-bottom:15px;
    line-height:1.6;
}
.image-box img{
    max-width:100%;
    border-radius:8px;
}
.two-col{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}
@media(max-width:768px){
    .two-col{
        grid-template-columns:1fr;
    }
    
    .sidebar {
        width: 220px;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .page-wrapper {
        margin-left: 0;
        max-width: 100%;
        padding: 20px 15px;
    }
    
    /* Mobile menu toggle button */
    .menu-toggle {
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1001;
        background: #1e3a8a;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 20px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
}

@media (min-width: 769px) {
    .menu-toggle {
        display: none;
    }
}

button{
    padding:10px 20px;
    background:#2c5aa0;
    color:#fff;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
</style>
</head>

<body>

<!-- Mobile Menu Toggle -->
<button class="menu-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>

<!-- Sidebar -->
<?php
// Calculate relative path to root directory
$includer_dir = realpath(dirname($_SERVER['SCRIPT_FILENAME']));
$root_dir = realpath(dirname(__FILE__) . '/../..');

// Calculate relative path from includer to root
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
    <h5><i class="bi bi-heart-fill"></i> Neurowel</h5>

    <a href="<?= $relative_path ?>index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="<?= $relative_path ?>users.php" class="<?= $current_page == 'users.php' ? 'active' : '' ?>">
        <i class="bi bi-people"></i> Users
    </a>

    <a data-bs-toggle="collapse" href="#cmsMenu">
        <i class="bi bi-layout-text-window"></i> CMS
    </a>
    <div class="collapse show" id="cmsMenu">
        <a class="sub-link <?= $current_page == 'veiw.php' ? 'active' : '' ?>" href="<?= $relative_path ?>cms/homepage/veiw.php">Home Page</a>
        <a class="sub-link <?= $current_page == 'view_about.php' ? 'active' : '' ?>" href="<?= $relative_path ?>cms/view_about.php">About Page</a>
        <a class="sub-link <?= $current_page == 'view.php' ? 'active' : '' ?>" href="<?= $relative_path ?>cms/what we do/view.php">What We Do</a>
        <a class="sub-link <?= $current_page == 'view.php' ? 'active' : '' ?>" href="<?= $relative_path ?>cms/our impact/view.php">Our Impact</a>
        <a class="sub-link <?= $current_page == 'gallery_admin.php' ? 'active' : '' ?>" href="<?= $relative_path ?>cms/gallery/gallery_admin.php">Gallery</a>
        <a class="sub-link <?= $current_page == 'get_involved_admin.php' ? 'active' : '' ?>" href="<?= $relative_path ?>cms/get_involved/get_involved_admin.php">Get Involved</a>
        <a class="sub-link <?= $current_page == 'veiw.php' ? 'active' : '' ?>" href="<?= $relative_path ?>cms/contact/veiw.php">contact</a>
    </div>

    <a href="<?= $relative_path ?>volunteers/volunteer.php" class="<?= $current_page == 'volunteer.php' ? 'active' : '' ?>">
        <i class="bi bi-person-check"></i> Volunteers
    </a>

    <a href="<?= $relative_path ?>donations/dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
        <i class="bi bi-cash-stack"></i> Donations
    </a>

    <a href="<?= $relative_path ?>campaigns.php" class="<?= $current_page == 'campaigns.php' ? 'active' : '' ?>">
        <i class="bi bi-flag"></i> Campaigns
    </a>

    <a href="<?= $relative_path ?>reports.php" class="<?= $current_page == 'reports.php' ? 'active' : '' ?>">
        <i class="bi bi-graph-up"></i> Reports
    </a>

    <a href="<?= $relative_path ?>settings.php" class="<?= $current_page == 'settings.php' ? 'active' : '' ?>">
        <i class="bi bi-gear"></i> Settings
    </a>

    <hr>

    <a href="<?= $relative_path ?>logout.php" class="text-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('show');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.querySelector('.menu-toggle');
    
    if (window.innerWidth <= 768) {
        if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove('show');
        }
    }
});
</script>

<div class="page-wrapper">

<h1 class="page-title">Contact Page</h1>

<!-- ================= CONTACT SECTION ================= -->
<div class="card">
    <div class="section-header">
        <h3>Contact Section</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=contact_title" class="edit-btn">Edit</a>
    </div>

    <div class="text"><strong>Title:</strong> <?= htmlspecialchars($data['contact_title'] ?? '') ?></div>
    <div class="text"><strong>Description:</strong> <?= htmlspecialchars($data['contact_description'] ?? '') ?></div>

    <div class="image-box">
        <?php
        $contact_image = $data['contact_image'] ?? '';
        if ($contact_image && file_exists("../../uploads/" . $contact_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($contact_image) . '" alt="Contact_Image">';
        } elseif (!empty($contact_image)) {
            echo '<small style="color:red;">Image not found: ' . htmlspecialchars($contact_image) . '</small>';
        }
        ?>
    </div>
</div>

<!-- ================= FORM SECTION ================= -->
<div class="card">
    <div class="section-header">
        <h3>Contact Form Section</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=form_title" class="edit-btn">Edit</a>
    </div>

    <div class="text"><strong>Form Title:</strong> <?= htmlspecialchars($data['form_title'] ?? '') ?></div>
    <div class="text"><strong>First Name Label:</strong> <?= htmlspecialchars($data['first_name'] ?? '') ?></div>
    <div class="text"><strong>Last Name Label:</strong> <?= htmlspecialchars($data['last_name'] ?? '') ?></div>
    <div class="text"><strong>Email Label:</strong> <?= htmlspecialchars($data['email_Address'] ?? '') ?></div>
    <div class="text"><strong>Phone Number Label:</strong> <?= htmlspecialchars($data['phonenumber'] ?? '') ?></div>
    <div class="text"><strong>Message Label:</strong> <?= htmlspecialchars($data['message'] ?? '') ?></div>
    <div class="text"><strong>Send Message Button:</strong> <?= htmlspecialchars($data['send_message'] ?? '') ?></div>
</div>

  


</div>
</body>
</html>

<?php mysqli_close($conn); ?>
