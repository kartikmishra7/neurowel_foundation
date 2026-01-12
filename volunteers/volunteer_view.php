<?php
include '../config.php';

$id = (int)$_GET['id'];

$q = mysqli_query($conn,"
    SELECT v.*, c.title AS campaign_title, c.status AS campaign_status
    FROM volunteers v
    LEFT JOIN campaigns c ON v.campaign_id=c.id
    WHERE v.id=$id
");

$v = mysqli_fetch_assoc($q);

if(!$v){
    die("Volunteer not found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Volunteer Profile</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

*{font-family:Poppins, sans-serif}

/* 🌗 THEME VARIABLES */
:root{
    --bg:#eef2f6;
    --card:#ffffff;
    --text:#111;
    --muted:#6c757d;
    --border:#e9ecef;
}

body.dark{
    --bg:#0f172a;
    --card:#0b1220;
    --text:#eaeffb;
    --muted:#a6b0c3;
    --border:#1f2937;
}

body{
    background:var(--bg);
    margin:0;
    padding:25px;
    color:var(--text);
    transition:.3s;
}

/* 🌗 TOGGLE BUTTON */
.theme-toggle{
    float:right;
    background:#2563eb;
    color:white;
    padding:8px 14px;
    border-radius:30px;
    cursor:pointer;
    font-size:13px;
    border:none;
}

/* MAIN CARD */
.wrapper{
    max-width:950px;
    margin:auto;
}

/* HEADER PROFILE CARD */
.profile-card{
    background:var(--card);
    padding:25px;
    border-radius:16px;
    box-shadow:0 10px 35px rgba(0,0,0,.08);
    text-align:center;
    border:1px solid var(--border);
}

.profile-card img{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid var(--border);
}

.name{
    font-size:22px;
    font-weight:600;
    margin-top:12px;
}

.vol-id{
    color:var(--muted);
    font-size:13px;
}

/* STATUS BADGES */
.badge{
    padding:6px 12px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.active{background:#28a745}
.inactive{background:#dc3545}
.pending{background:#ffc107;color:#000}
.approved{background:#0d6efd}
.rejected{background:#6c757d}

/* INFO GRID CARD */
.info-card,
.campaign-card,
.aadhaar-box{
    background:var(--card);
    margin-top:18px;
    padding:22px;
    border-radius:16px;
    box-shadow:0 6px 25px rgba(0,0,0,.05);
    border:1px solid var(--border);
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

.info-item b{
    font-size:13px;
    color:var(--muted);
}
.info-item span{
    display:block;
    font-size:14px;
}

/* CAMPAIGN BADGE */
.event-badge{
    background:#6f42c1;
    padding:6px 14px;
    color:white;
    border-radius:20px;
    display:inline-block;
    font-size:12px;
}

/* AADHAAR */
.aadhaar-box img{
    width:260px;
    border-radius:10px;
    border:1px solid var(--border);
}

/* BUTTONS */
.btn{
    padding:10px 14px;
    color:white;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    margin-right:6px;
}

.approve{background:#28a745}
.reject{background:#dc3545}
.edit{background:#007bff}
.back{background:#6c757d}
.activate{background:#17a2b8}
.certificate{background:#ff9f43}

/* RESPONSIVE */
@media(max-width:768px){
    .info-grid{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<div class="wrapper">

<button class="theme-toggle" onclick="toggleTheme()">🌗 Toggle Mode</button>

<!-- PROFILE CARD -->
<div class="profile-card">

<img src="../<?= $v['photo'] ?: 'assets/user.png' ?>">

<div class="name"><?= htmlspecialchars($v['full_name']) ?></div>

<div class="vol-id">
Volunteer ID: <?= $v['volunteer_id'] ?: 'Not Assigned' ?>
</div>

<br>

<span class="badge <?= $v['is_active']?'active':'inactive' ?>">
<?= $v['is_active']?'Active':'Inactive' ?>
</span>

<span class="badge <?= $v['status'] ?>">
<?= ucfirst($v['status']) ?>
</span>

</div>

<!-- PERSONAL INFO -->
<div class="info-card">
<h3>Personal Information</h3>

<div class="info-grid">

<div class="info-item">
<b>Email</b>
<span><?= htmlspecialchars($v['email']) ?></span>
</div>

<div class="info-item">
<b>Phone</b>
<span><?= htmlspecialchars($v['phone']) ?></span>
</div>

<div class="info-item">
<b>Address</b>
<span><?= nl2br(htmlspecialchars($v['address'])) ?></span>
</div>

<div class="info-item">
<b>Aadhaar</b>
<span>XXXX-XXXX-<?= substr($v['aadhaar_number'],-4) ?></span>
</div>

</div>
</div>

<!-- CAMPAIGN -->
<div class="campaign-card">
<h3>Campaign Participation</h3>

<?php if($v['campaign_id']){ ?>

<span class="event-badge">📢 <?= htmlspecialchars($v['campaign_title']) ?></span><br><br>

<?php if($v['campaign_status']=="completed"){ ?>

<?php
if(empty($v['certificate_id'])){
    $certId = 'CERT-'.date('Y').'-'.str_pad($v['id'],5,'0',STR_PAD_LEFT);
    mysqli_query($conn,"UPDATE volunteers SET certificate_id='$certId' WHERE id={$v['id']}");
    $v['certificate_id']=$certId;
}
?>

<p><b>Certificate ID:</b> <?= $v['certificate_id'] ?></p>

<a class="btn certificate" target="_blank"href="certificate.php?vid=<?= $v['id'] ?>"
 ?>🎓 Download Certificate</a>

<?php } else { ?>
<p style="color:gray">Certificate after completion</p>
<?php } ?>

<?php } else { ?>
<p style="color:gray">No campaign participated</p>
<?php } ?>
</div>

<!-- AADHAAR -->
<div class="aadhaar-box">
<h3>Aadhaar Document</h3>
<img src="../<?= $v['aadhaar_image'] ?>">
</div>

<br>

<!-- ACTION BUTTONS -->
<?php if($v['status']=='pending'){ ?>
<a class="btn approve" href="volunteer_action.php?id=<?= $v['id'] ?>&type=approve">Approve</a>
<a class="btn reject" href="volunteer_action.php?id=<?= $v['id'] ?>&type=reject">Reject</a>
<?php } ?>

<?php if($v['status']=='approved'){ ?>
<?php if($v['is_active']){ ?>
<a class="btn reject" href="volunteer_action.php?id=<?= $v['id'] ?>&type=deactivate">Deactivate</a>
<?php } else { ?>
<a class="btn activate" href="volunteer_action.php?id=<?= $v['id'] ?>&type=activate">Activate</a>
<?php } ?>
<?php } ?>

<a class="btn edit" href="volunteer_edit.php?id=<?= $v['id'] ?>">Edit</a>
<a class="btn back" href="volunteer.php">Back</a>

</div>

<!--  DARK MODE SCRIPT -->
<script>
function toggleTheme(){
    document.body.classList.toggle("dark");
    localStorage.setItem("mode",
        document.body.classList.contains("dark") ? "dark" : "light"
    );
}

if(localStorage.getItem("mode")==="dark"){
    document.body.classList.add("dark");
}
</script>

</body>
</html>
