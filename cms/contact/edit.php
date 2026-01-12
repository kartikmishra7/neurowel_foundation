<?php
include "../../config.php";

$id = (int)$_GET['id'];
$section = $_GET['section'];

$q = mysqli_query($conn, "SELECT * FROM contact_page WHERE id=$id");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data not found");
}

// Get current page filename for sidebar
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Contact Page</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
  background:#f8fafc;
  font-family:"Poppins","Segoe UI",Arial,sans-serif;
  margin:0;
  color:#1f2937;
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

.collapse{
    margin-top:5px;
}

.collapse.show{
    display:block;
}

.wrapper{
  margin-left:280px;
  padding:40px 30px;
  max-width:calc(100% - 280px);
}

.card{
  background:#ffffff;
  padding:32px;
  border-radius:20px;
  box-shadow:0 20px 40px rgba(0,0,0,0.06);
  border:1px solid #E5E7EB;
}

h2{
  text-align:center;
  color:#1e3a8a;
}

.section-title{
  margin-top:36px;
  padding-top:18px;
  border-top:1px dashed #DBEAFE;
  font-size:18px;
  font-weight:500;
  color:#1d4ed8;
}

label{
  display:block;
  margin-top:18px;
  margin-bottom:6px;
  font-weight:500;
}

textarea{
  width:100%;
  min-height:120px;
  padding:12px;
  border-radius:12px;
  border:1px solid #BFDBFE;
  box-sizing: border-box;
}

input[type="text"],
input[type="email"],
input[type="tel"]{
  width:100%;
  padding:12px;
  border-radius:12px;
  border:1px solid #BFDBFE;
  box-sizing: border-box;
  font-size:16px;
}

input[type="file"]{
  margin-top:10px;
}

.preview img{
  max-width:200px;
  margin-top:12px;
  border-radius:12px;
  border:1px solid #E5E7EB;
}

button{
  margin-top:30px;
  width:100%;
  padding:14px;
  border-radius:12px;
  border:none;
  color:white;
  background:#1d4ed8;
  cursor:pointer;
  font-size:16px;
}

button:hover{
  background:#1e40af;
}

@media (max-width: 768px) {
    .sidebar {
        width: 220px;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .wrapper {
        margin-left: 0;
        max-width: 100%;
        padding: 20px 15px;
    }
    
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
</style>
</head>

<body>

<!-- Mobile Menu Toggle -->
<button class="menu-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>

<!-- Sidebar -->
<?php
$includer_dir = realpath(dirname($_SERVER['SCRIPT_FILENAME']));
$root_dir = realpath(dirname(__FILE__) . '/../..');

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
        <a class="sub-link <?= $current_page == 'veiw.php' ? 'active' : '' ?>" href="<?= $relative_path ?>cms/contact/veiw.php">Contact</a>
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

<div class="wrapper">
<div class="card">

<h2>Edit Contact Page Content</h2>

<?php if (empty($section)): ?>
    <div style="padding:20px; background:#fee; color:#c00; border-radius:8px; margin-bottom:20px;">
        <strong>Error:</strong> No section specified. Please go back and click an edit button.
    </div>
<?php endif; ?>

<form method="POST" action="update.php" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $data['id'] ?>">
<input type="hidden" name="section" value="<?= htmlspecialchars($section) ?>">

<!-- ================= CONTACT SECTION ================= -->
<?php if ($section == "contact_title"): ?>

<div class="section-title">Contact Section</div>

<label>Contact Title</label>
<textarea name="contact_title"><?= htmlspecialchars($data['contact_title'] ?? '') ?></textarea>

<label>Contact Description</label>
<textarea name="contact_description"><?= htmlspecialchars($data['contact_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['contact_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['contact_image']) ?>" alt="Contact_Image">
<?php endif; ?>
</div>

<label>Change Contact Image</label>
<input type="file" name="contact_image">

<?php endif; ?>

<!-- ================= FORM SECTION ================= -->
<?php if ($section == "form_title"): ?>

<div class="section-title">Contact Form Section</div>

<label>Form Title</label>
<input type="text" name="form_title" value="<?= htmlspecialchars($data['form_title'] ?? '') ?>">

<label>First Name Label</label>
<input type="text" name="first_name" value="<?= htmlspecialchars($data['first_name'] ?? '') ?>">

<label>Last Name Label</label>
<input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name'] ?? '') ?>">

<label>Email Address Label</label>
<input type="text" name="email_Address" value="<?= htmlspecialchars($data['email_Address'] ?? '') ?>">

<label>Phone Number Label</label>
<input type="text" name="phonenumber" value="<?= htmlspecialchars($data['phonenumber'] ?? '') ?>">

<label>Message Label</label>
<textarea name="message"><?= htmlspecialchars($data['message'] ?? '') ?></textarea>

<label>Send Message Button Text</label>
<input type="text" name="send_message" value="<?= htmlspecialchars($data['send_message'] ?? '') ?>">

<?php endif; ?>

<?php 
$sections = ["contact_title", "form_title"];
if (!empty($section) && !in_array($section, $sections)): ?>
    <div style="padding:20px; background:#fee; color:#c00; border-radius:8px; margin-bottom:20px;">
        <strong>Error:</strong> Unknown section "<?= htmlspecialchars($section) ?>". Please check the section parameter.
    </div>
<?php endif; ?>

<button type="submit">Update Content</button>

</form>

</div>
</div>
</body>
</html>


