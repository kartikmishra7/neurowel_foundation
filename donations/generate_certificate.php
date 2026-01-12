<?php
$vol = $_GET['vol'];
$camp = $_GET['camp'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>

<style>
body{background:#f3f3f3;text-align:center;font-family:Arial}
.box{
    width:750px;
    margin:auto;
    background:white;
    padding:40px;
    border:4px solid #222;
    border-radius:15px;
    margin-top:40px;
}
</style>

</head>
<body>

<div class="box">
<h1>Certificate of Appreciation</h1>

<p>This certificate is awarded to</p>

<h2><?= htmlspecialchars($vol) ?></h2>

<p>for volunteering in</p>

<h3><?= htmlspecialchars($camp) ?></h3>

<p>We appreciate your contribution 🙏</p>

</div>

</body>
</html>
