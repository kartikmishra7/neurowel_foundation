<?php
include "../../config.php";

$id = (int)$_GET['id'];
$section = $_GET['section'];

$q = mysqli_query($conn, "SELECT * FROM welcome_homepage WHERE id=$id");
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
<title>Edit Our Home Page</title>
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

/* Collapse Menu */
.collapse{
    margin-top:5px;
}

.collapse.show{
    display:block;
}

/* Main Content Area */
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

/* Responsive Design */
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
    
    .card {
        padding: 20px;
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

<div class="wrapper">
<div class="card">

<h2>Edit Homepage Content</h2>

<?php if (empty($section)): ?>
    <div style="padding:20px; background:#fee; color:#c00; border-radius:8px; margin-bottom:20px;">
        <strong>Error:</strong> No section specified. Please go back and click an edit button.
    </div>
<?php endif; ?>

<form method="POST" action="update.php" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $data['id'] ?>">
<input type="hidden" name="section" value="<?= htmlspecialchars($section) ?>">

<!-- ================= HERO SECTION ================= -->
<?php if ($section == "hero_title"): ?>

<div class="section-title">Hero Section</div>

<label>Hero Title</label>
<textarea name="hero_title"><?= htmlspecialchars($data['hero_title']) ?></textarea>

<label>Hero Description</label>
<textarea name="hero_description"><?= htmlspecialchars($data['hero_description']) ?></textarea>

<label>Donation Button Text</label>
<textarea name="hero_donation_btn"><?= htmlspecialchars($data['hero_donation_btn']) ?></textarea>

<label>Volunteer Button Text</label>
<textarea name="hero_volunteers_btn"><?= htmlspecialchars($data['hero_volunteers_btn']) ?></textarea>

<div class="preview">
<?php if (!empty($data['hero_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['hero_image']) ?>" alt="Hero Image">
<?php endif; ?>
</div>

<label>Change Hero Image</label>
<input type="file" name="hero_image">

<?php endif; ?>

<!-- ================= WELCOME SECTION ================= -->
<?php if ($section == "welcome_page_title"): ?>

<div class="section-title">Welcome Section</div>

<label>Welcome Title</label>
<textarea name="welcome_page_title"><?= htmlspecialchars($data['welcome_page_title']) ?></textarea>

<label>Welcome Description</label>
<textarea name="welcome_page_description"><?= htmlspecialchars($data['welome_page_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['welcome_page_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['welcome_page_image']) ?>" alt="Welcome Image">
<?php endif; ?>
</div>

<label>Change Welcome Image</label>
<input type="file" name="welcome_page_image">

<?php endif; ?>

<!-- ================= OUR FOCUS TITLE ================= -->
<?php if ($section == "our_focus_title"): ?>

<div class="section-title">Our Focus Area</div>

<label>Our Focus Area Title</label>
<textarea name="our_focus_title"><?= htmlspecialchars($data['our_focus_title']) ?></textarea>

<?php endif; ?>

<!-- ================= FOOD SECURITY ================= -->
<?php if ($section == "food_security_title"): ?>

<div class="section-title">Food Security & Sustained Growth</div>

<label>Food Security Title</label>
<textarea name="food_security_title"><?= htmlspecialchars($data['food_security_title']) ?></textarea>

<label>Food Security Description</label>
<textarea name="food_security_description"><?= htmlspecialchars($data['food_security_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['food_security_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['food_security_image']) ?>" alt="Food Security Image">
<?php endif; ?>
</div>

<label>Change Food Security Image</label>
<input type="file" name="food_security_image">

<?php endif; ?>

<!-- ================= CLOTHING ================= -->
<?php if ($section == "clothing_title"): ?>

<div class="section-title">Clothing Distribution</div>

<label>Clothing Title</label>
<textarea name="clothing_title"><?= htmlspecialchars($data['clothing_title']) ?></textarea>

<label>Clothing Description</label>
<textarea name="clothing_description"><?= htmlspecialchars($data['clothing_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['clothing_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['clothing_image']) ?>" alt="Clothing Image">
<?php endif; ?>
</div>

<label>Change Clothing Image</label>
<input type="file" name="clothing_image">

<?php endif; ?>

<!-- ================= EDUCATION ================= -->
<?php if ($section == "eduction_title"): ?>

<div class="section-title">Education</div>

<label>Education Title</label>
<textarea name="eduction_title"><?= htmlspecialchars($data['eduction_title'] ?? '') ?></textarea>

<label>Education Description</label>
<textarea name="eduction_description"><?= htmlspecialchars($data['eduction_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['eduction_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['eduction_image']) ?>" alt="Education Image">
<?php endif; ?>
</div>

<label>Change Education Image</label>
<input type="file" name="eduction_image">

<?php endif; ?>

<!-- ================= LIVELIHOOD ================= -->
<?php if ($section == "livelihood_title"): ?>

<div class="section-title">Livelihood & Skill Development</div>

<label>Livelihood Title</label>
<textarea name="livelihood_title"><?= htmlspecialchars($data['livelihood_title']) ?></textarea>

<label>Livelihood Description</label>
<textarea name="livelihood_description"><?= htmlspecialchars($data['livelihood_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['livelihood_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['livelihood_image']) ?>" alt="Livelihood Image">
<?php endif; ?>
</div>

<label>Change Livelihood Image</label>
<input type="file" name="livelihood_image">

<?php endif; ?>

<!-- ================= COMMUNITY ================= -->
<?php if ($section == "community_title"): ?>

<div class="section-title">Community Development</div>

<label>Community Title</label>
<textarea name="community_title"><?= htmlspecialchars($data['community_title']) ?></textarea>

<label>Community Description</label>
<textarea name="community_description"><?= htmlspecialchars($data['community_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['community_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['community_image']) ?>" alt="Community Image">
<?php endif; ?>
</div>

<label>Change Community Image</label>
<input type="file" name="community_image">

<?php endif; ?>

<!-- ================= OUR IMPACT ================= -->
<?php if ($section == "our_impact_title"): ?>

<div class="section-title">Our Impact</div>

<label>Our Impact Title</label>
<textarea name="our_impact_title"><?= htmlspecialchars($data['our_impact_title']) ?></textarea>

<label>Our Impact Description</label>
<textarea name="our_impact_description"><?= htmlspecialchars($data['our_impact_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['our_impact_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['our_impact_image']) ?>" alt="Our Impact Image">
<?php endif; ?>
</div>

<label>Change Our Impact Image</label>
<input type="file" name="our_impact_image">

<?php endif; ?>

<!-- ================= MENTAL WELLNESS ================= -->
<?php if ($section == "mental_title"): ?>

<div class="section-title">Mental Wellness & Emotional Development</div>

<label>Mental Title</label>
<textarea name="mental_title"><?= htmlspecialchars($data['mental_title'] ?? '') ?></textarea>

<label>Mental Description</label>
<textarea name="mental_description"><?= htmlspecialchars($data['mental_description'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['mental_image'])): ?>
    <img src="../../uploads/<?= htmlspecialchars($data['mental_image']) ?>" alt="Mental Image">
<?php endif; ?>
</div>

<label>Change Mental Image</label>
<input type="file" name="mental_image">

<?php endif; ?>

<!-- ================= MEDIA ================= -->
<?php if ($section == "media_title"): ?>

<div class="section-title">Media & Stories</div>

<label>Media Title</label>
<textarea name="media_title"><?= htmlspecialchars($data['media_title'] ?? '') ?></textarea>

<label>Media Description</label>
<textarea name="media_description"><?= htmlspecialchars($data['media_description'] ?? '') ?></textarea>

<label>Media Video Title</label>
<textarea name="media_video_title"><?= htmlspecialchars($data['media_video_title'] ?? '') ?></textarea>

<div class="preview">
<?php if (!empty($data['media_video_image'])): ?>
    <?php
    $videos = $data['media_video_image'];
    if ($videos) {
        $videoFiles = array_map('trim', explode(',', $videos));
        foreach ($videoFiles as $video) {
            $path = "../../uploads/" . $video;
            if (file_exists($path)) {
                $ext = strtolower(pathinfo($video, PATHINFO_EXTENSION));
                if (in_array($ext, ['mp4','webm','ogg'])) {
                    echo '<video width="200px" controls style="margin-bottom:10px;"><source src="'.$path.'" type="video/'.$ext.'"></video><br>';
                } else {
                    echo '<img src="'.$path.'" alt="Media" style="max-width:200px; margin-bottom:10px;"><br>';
                }
            }
        }
    }
    ?>
<?php endif; ?>
</div>

<label>Change Media Video/Image (comma-separated for multiple)</label>
<input type="file" name="media_video_image[]" multiple>

<?php endif; ?>

<?php 
// Check if any section was displayed
$sections = ["hero_title", "welcome_page_title", "our_focus_title", "food_security_title", 
             "clothing_title", "eduction_title", "livelihood_title", "community_title", 
             "our_impact_title", "mental_title", "media_title"];
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