<?php
session_start();

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
$query  = "SELECT * FROM welcome_homepage ORDER BY id DESC LIMIT 1";
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
<title>Home Page Preview</title>
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

/* Action Buttons */
.action-buttons-container{
    margin-top:50px;
    padding:30px 0;
    border-top:2px solid #e5e7eb;
}

.action-buttons{
    display:flex;
    gap:20px;
    justify-content:center;
    flex-wrap:wrap;
}

.btn-preview,
.btn-publish{
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:16px 32px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    font-size:16px;
    transition:all 0.3s ease;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    border:none;
    cursor:pointer;
}

.btn-preview{
    background:linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color:#fff;
}

.btn-preview:hover{
    background:linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    transform:translateY(-2px);
    box-shadow:0 6px 20px rgba(59,130,246,0.4);
    color:#fff;
}

.btn-publish{
    background:linear-gradient(135deg, #10b981 0%, #059669 100%);
    color:#fff;
}

.btn-publish:hover{
    background:linear-gradient(135deg, #059669 0%, #047857 100%);
    transform:translateY(-2px);
    box-shadow:0 6px 20px rgba(16,185,129,0.4);
    color:#fff;
}

.btn-preview i,
.btn-publish i{
    font-size:20px;
}

@media(max-width:768px){
    .action-buttons{
        flex-direction:column;
    }
    
    .btn-preview,
    .btn-publish{
        width:70%;
        justify-content:center;
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

<div class="page-wrapper">

<h1 class="page-title">Home Page</h1>

<!-- ================= HERO SECTION ================= -->
<div class="card">
    <div class="section-header">
        <h3>Hero Section</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=hero_title" class="edit-btn">Edit</a>
    </div>

    <div class="text"><?= htmlspecialchars($data['hero_title']) ?></div>
    <div class="text"><?= htmlspecialchars($data['hero_description']) ?></div>

    <button><?= htmlspecialchars($data['hero_donation_btn']) ?></button>
    <br><br>
    <button><?= htmlspecialchars($data['hero_volunteers_btn']) ?></button>

    <div class="image-box">
        <?php
        $hero_image = $data['hero_image'] ?? '';
        if ($hero_image && file_exists("../../uploads/" . $hero_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($hero_image) . '">';
        }
        ?>
    </div>
</div>

<!-- ================= WELCOME SECTION ================= -->
<div class="card">
    <div class="section-header">
        <h3>Welcome to Neurowl Foundation</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=welcome_page_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['welcome_page_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['welome_page_description']) ?></div>
    </div>

    <div class="image-box">
        <?php
        $welcome_image = $data['welcome_page_image'] ?? '';
        if ($welcome_image && file_exists("../../uploads/" . $welcome_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($welcome_image) . '">';
        }
        ?>
    </div>
</div>

  <!-- our focus area -->
<div class="card">
    <div class="section-header">
        <h3>  Our Focus Area</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=our_focus_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['our_focus_title']) ?></div>
       
    </div>

        
    </div>
    <div class="card">
    <div class="section-header">
        <h3>Food Security & Sustainable Growth</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=food_security_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['food_security_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['food_security_description']) ?></div>
    </div>

    <div class="image-box">
        <?php
        $food_security_image = $data['food_security_image'] ?? '';
        if ($food_security_image && file_exists("../../uploads/" . $food_security_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($food_security_image) . '">';
        }
        ?>
    </div>
</div>
<div class="card">
    <div class="section-header">
        <h3>Clothing Distribution</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=clothing_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['clothing_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['clothing_description']) ?></div>
    </div>

    <div class="image-box">
        <?php
        $clothing_image = $data['clothing_image'] ?? '';
        if ($clothing_image && file_exists("../../uploads/" . $clothing_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($clothing_image) . '">';
        }
        ?>
    </div>
</div>
<div class="card">
    <div class="section-header">
        <h3>Eduction Support</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=eduction_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['eduction_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['eduction_description']) ?></div>
    </div>

    <div class="image-box">
        <?php
        $eduction_image = $data['eduction_image'] ?? '';
        if ($eduction_image && file_exists("../../uploads/" . $eduction_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($eduction_image) . '">';
        }
        ?>
    </div>
</div>
<div class="card">
    <div class="section-header">
        <h3>Livelihood & Skill Development</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=livelihood_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['livelihood_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['livelihood_description']) ?></div>
    </div>

    <div class="image-box">
        <?php
        $livelihood_image = $data['livelihood_image'] ?? '';
        if ($livelihood_image && file_exists("../../uploads/" . $livelihood_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($livelihood_image) . '">';
        }
        ?>
    </div>
</div>
<div class="card">
    <div class="section-header">
        <h3>Mental Wellness And Emotional Care</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=mental_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['mental_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['mental_description']) ?></div>
    </div>

    <div class="image-box">
        <?php
        $mental_image = $data['mental_image'] ?? '';
        if ($mental_image && file_exists("../../uploads/" . $mental_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($mental_image) . '">';
        }
        ?>
    </div>
</div>
<div class="card">
    <div class="section-header">
        <h3>Community Development</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=community_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['community_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['community_description']) ?></div>
    </div>

    <div class="image-box">
        <?php
        $community_image = $data['community_image'] ?? '';
        if ($community_image && file_exists("../../uploads/" . $community_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($community_image) . '">';
        }
        ?>
    </div>
</div>
<div class="card">
    <div class="section-header">
        <h3>Our Impact</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=our_impact_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['our_impact_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['our_impact_description']) ?></div>
    </div>

    <div class="image-box">
        <?php
        $our_impact_image = $data['our_impact_image'] ?? '';
        if ($our_impact_image && file_exists("../../uploads/" . $our_impact_image)) {
            echo '<img src="../../uploads/' . htmlspecialchars($our_impact_image) . '">';
        }
        ?>
    </div>
</div>
<div class="card">
    <div class="section-header">
        <h3>Media And Stories</h3>
        <a href="edit.php?id=<?= $data['id'] ?>&section=media_title" class="edit-btn">Edit</a>
    </div>

    <div class="two-col">
        <div class="text"><?= htmlspecialchars($data['media_title']) ?></div>
        <div class="text"><?= htmlspecialchars($data['media_description']) ?></div>
         <div class="text"><?= htmlspecialchars($data['media_video_title']) ?></div>
<div class="card">
    <div class="section-header">
        <h3><?= htmlspecialchars($data['media_title']) ?></h3>
    </div>

    <p class="text"><?= htmlspecialchars($data['media_description']) ?></p>

    <?php if (!empty($data['media_video_title'])): ?>
        <h4><?= htmlspecialchars($data['media_video_title']) ?></h4>
    <?php endif; ?>

    <div class="image-box">
    <?php
    $videos = $data['media_video_image'] ?? '';

    if ($videos) {

        $videoFiles = array_map('trim', explode(',', $videos));

        foreach ($videoFiles as $video) {

            $path = "../../uploads/" . $video;

            if (!file_exists($path)) continue;

            $ext = strtolower(pathinfo($video, PATHINFO_EXTENSION));

            if (in_array($ext, ['mp4','webm','ogg'])) {
                echo '
                <video width="100%" controls style="margin-bottom:20px;">
                    <source src="'.$path.'" type="video/'.$ext.'">
                    Your browser does not support video.
                </video>';
            }
        }
    }
    ?>
    </div>
</div>

<!-- Action Buttons -->
<div class="action-buttons-container">
    <div class="action-buttons">
        <a href="preview.php" target="_blank" class="btn-preview">
            <i class="bi bi-eye"></i> Preview Homepage
        </a>
        <a href="<?= $relative_path ?>index.php" target="_blank" class="btn-publish">
            <i class="bi bi-check-circle"></i> Publish & View Live
        </a>
    </div>
</div>





</div>
</body>
</html>

<?php mysqli_close($conn); ?>
