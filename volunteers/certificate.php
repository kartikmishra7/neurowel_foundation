<?php
include '../config.php';

if (!isset($_GET['vid'])) {
    die("Invalid certificate request");
}

$vid = (int) $_GET['vid'];

$q = mysqli_query($conn,"
SELECT 
    v.full_name,
    v.certificate_id,
    c.title
FROM volunteers v
JOIN campaigns c ON v.campaign_id = c.id
WHERE 
    v.id = $vid 
    AND v.certificate_id IS NOT NULL
    AND c.status = 'completed'
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Certificate not available");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Volunteer Certificate</title>

<style>
body{
    background:#f4f6f8;
    font-family:Georgia, serif;
    padding:40px;
}
.cert{
    background:#fff;
    padding:60px;
    max-width:900px;
    margin:auto;
    text-align:center;
    border:12px solid #2ecc71;
    position:relative;
}
.cert-id{
    position:absolute;
    top:30px;
    right:50px;
    font-size:14px;
}
.name{
    font-size:32px;
    font-weight:bold;
    margin:20px 0;
}
.download-btn{
    display:block;
    margin:30px auto;
    padding:10px 20px;
    background:#2ecc71;
    color:#fff;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
}
@media print{
    .download-btn{ display:none; }
    body{ background:#fff; padding:0; }
}
</style>
</head>

<body>

<button class="download-btn" onclick="window.print()">⬇ Download Certificate (PDF)</button>

<div class="cert">

<div class="cert-id">
Certificate ID: <?= htmlspecialchars($data['certificate_id']) ?>
</div>

<h1>Certificate of Participation</h1>
<p>This certificate is proudly presented to</p>

<div class="name"><?= htmlspecialchars($data['full_name']) ?></div>

<p>for successfully participating in</p>
<h2><?= htmlspecialchars($data['title']) ?></h2>

<p>Date: <?= date('d M Y') ?></p>

</div>

</body>
</html>
