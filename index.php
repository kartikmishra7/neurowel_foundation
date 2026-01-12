<?php
include 'config.php';
require_once 'auth.php';

$auth = new Auth();

if (!$auth->check()) {
    header("Location: login.php");
    exit;
}


/* SHOW ERRORS */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* COUNTS */
$volunteers = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT COUNT(*) AS total 
    FROM volunteers 
    WHERE status='approved' AND is_active=1
"));

$donors = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT COUNT(*) AS total FROM donors
"));

$donation = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT SUM(amount) AS total FROM donations
"));

$campaigns = mysqli_query($conn,"
    SELECT id, title, status, target_amount, collected_amount 
    FROM campaigns 
    ORDER BY id DESC 
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Neurowel Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
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
}
.sidebar a{
    color:#fff;
    text-decoration:none;
    display:block;
    padding:10px 12px;
    border-radius:8px;
    margin-bottom:6px;
    font-size:14px;
}
.sidebar a:hover,
.sidebar a.active{
    background:rgba(255,255,255,0.2);
}
.main{
    margin-left:240px;
    padding:30px;
}
.card{
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}
.status-badge{
    padding:4px 10px;
    border-radius:12px;
    font-size:12px;
    color:#fff;
    font-weight:bold;
}
.active-badge{background:#28a745;}
.upcoming-badge{background:#ff9f43;}
.completed-badge{background:#7367f0;}
.list-group-item{
    border:none;
    padding:15px 20px;
    border-radius:10px;
    margin-bottom:10px;
    box-shadow:0 3px 8px rgba(0,0,0,0.05);
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.card-link {
    display: block;       /* Make link block to cover full card */
    text-decoration: none; /* Remove underline */
    color: inherit;        /* Keep text color inside card */
}
</style>
</head>

<body>
    

<!-- SLIDER SOURCE ONLY -->
<?php include 'sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="main">

<h3 class="mb-4">📊 Dashboard Overview</h3>

<div class="row g-4">
    <!-- Total Donation -->
    <div class="col-md-4">
        <a href="donations/donation_list.php" class="card-link">
            <div class="card p-3 text-center bg-white">
                <h6>Total Donation</h6>
                <h3>₹<?= number_format($donation['total'] ?? 0) ?></h3>
            </div>
        </a>
    </div>

    <!-- Donors -->
    <div class="col-md-4">
        <a href="donations/donors.php" class="card-link">
            <div class="card p-3 text-center bg-white">
                <h6> Donors</h6>
                <h3><?= $donors['total'] ?></h3>
            </div>
        </a>
    </div>

    <!-- Active Campaigns -->
    <div class="col-md-4">
        <a href="donations/campaigns.php" class="card-link">
            <div class="card p-3 text-center bg-white">
                <h6>Active Campaigns</h6>
                <h3><?= mysqli_num_rows($campaigns) ?></h3>
            </div>
        </a>
    </div>
</div>

<h4 class="mt-5 mb-3">📌 Recent Campaigns</h4>

<?php if(mysqli_num_rows($campaigns) > 0){ ?>
<ul class="list-group">
<?php while($row = mysqli_fetch_assoc($campaigns)){
    $status_class = 'active-badge';
    if($row['status']=='upcoming') $status_class='upcoming-badge';
    if($row['status']=='completed') $status_class='completed-badge';
?>
<li class="list-group-item">
    <div>
        <strong><?= htmlspecialchars($row['title']) ?></strong><br>
        <small>ID: <?= $row['id'] ?> | Goal: ₹<?= number_format($row['target_amount']) ?></small>
    </div>
    <span class="status-badge <?= $status_class ?>">
        <?= ucfirst($row['status']) ?>
    </span>
</li>
<?php } ?>
</ul>
<?php } else { echo "<p>No campaigns found.</p>"; } ?>

</div>
</body>
</html>
