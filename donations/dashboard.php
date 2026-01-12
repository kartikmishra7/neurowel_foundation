<?php
include '../config.php';

/* ===== DASHBOARD STATS ===== */
$totalAmount = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT SUM(amount) AS total FROM donations")
)['total'] ?? 0;

$totalDonors = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(DISTINCT donor_id) AS total FROM donations")
)['total'] ?? 0;

$totalRecurring = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM donations WHERE donation_type='recurring'")
)['total'] ?? 0;

$totalCampaigns = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM campaigns")
)['total'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Donation Dashboard</title>

<style>
body{
  font-family:Segoe UI, Arial;
  background:#f4f6fb;
  margin:0;
}

/* MAIN */
.main{
  margin-left:260px;
  padding:25px;
}

/* HEADER */
.header-row{
  display:flex;
  align-items:center;
  justify-content:space-between;
}
.subtitle{
  color:#666;
  font-size:14px;
}

/* DASHBOARD CARDS */
.stats{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
  gap:20px;
  margin:25px 0;
}

.stat-card{
  background:#fff;
  padding:22px;
  border-radius:14px;
  box-shadow:0 6px 18px rgba(0,0,0,.06);
  border-left:6px solid #28c76f;
}

.stat-title{
  font-size:14px;
  color:#777;
}
.stat-value{
  font-size:34px;
  font-weight:bold;
  margin-top:8px;
}

/* TABLE */
.card{
  background:#fff;
  padding:22px;
  border-radius:14px;
  box-shadow:0 6px 18px rgba(0,0,0,.06);
  margin-bottom:25px;
}

table{
  width:100%;
  border-collapse:collapse;
}
th,td{
  padding:12px;
  border-bottom:1px solid #eee;
  font-size:14px;
}
th{
  background:#f8fafc;
  text-align:left;
}

.badge{
  background:#e7f9ee;
  color:#18a558;
  padding:6px 14px;
  border-radius:20px;
  font-size:12px;
}

/* PROGRESS */
.progress{
  background:#e1e5ea;
  border-radius:10px;
  height:10px;
}
.progress div{
  background:#28c76f;
  height:10px;
  border-radius:10px;
}

.btn{
  float:right;
  background:#28c76f;
  color:#fff;
  padding:8px 14px;
  border-radius:8px;
  text-decoration:none;
  font-size:13px;
}
</style>
</head>

<body>
<?php include '../sidebar.php'; ?>
<div class="main">

<!-- HEADER -->
<div class="header-row">
  <h1>Donation Dashboard</h1>
  <span class="subtitle">Track & manage all donation activities</span>
</div>

<!-- TOTAL DONATION DESIGN (FIXED) -->
 <a href="donation_list.php" style="text-decoration:none;color:inherit;">
<div class="stats">
  <div class="stat-card">
    <div class="stat-title">Total Donations</div>
    <div class="stat-value">₹<?= number_format($totalAmount) ?></div>
  </div>
<a href="donors.php" style="text-decoration:none;color:inherit;">
  <div class="stat-card">
    <div class="stat-title">Total Donors</div>
    <div class="stat-value"><?= $totalDonors ?></div>
  </div>
<a href="recurring_donation.php" style="text-decoration:none;color:inherit;">
  <div class="stat-card">
    <div class="stat-title">Recurring Donations</div>
    <div class="stat-value"><?= $totalRecurring ?></div>
  </div>
<a href="campaigns.php" style="text-decoration:none;color:inherit;">
  <div class="stat-card">
    <div class="stat-title">Campaigns</div>
    <div class="stat-value"><?= $totalCampaigns ?></div>
  </div>
</div>

<!-- DONATION TRACKING TABLE -->
 
<div class="card">
<h2>Donation Tracking</h2>

<table>
<tr>
  <th>Date</th>
  <th>Donor</th>
  <th>Amount</th>
  <th>Type</th>
  <th>Payment</th>
  <th>Campaign</th>
  <th>Status</th>
</tr>

<?php
$q = mysqli_query($conn,"
SELECT d.*, c.title AS campaign_title
FROM donations d
LEFT JOIN campaigns c ON d.campaign_id = c.id
ORDER BY d.id DESC
LIMIT 10
");

if(mysqli_num_rows($q)){
while($row=mysqli_fetch_assoc($q)){
?>
<tr>
  <td><?= $row['donated_on'] ?></td>
  <td><?= $row['donor_name'] ?? 'Anonymous' ?></td>
  <td>₹<?= number_format($row['amount']) ?></td>
  <td><?= ucfirst($row['donation_type']) ?></td>
  <td><?= ucfirst($row['payment_method']) ?></td>
  <td><?= $row['campaign_title'] ?? '-' ?></td>
  <td><span class="badge"><?= ucfirst($row['status']) ?></span></td>
</tr>
<?php }} else { ?>
<tr><td colspan="7">No donations found</td></tr>
<?php } ?>
</table>
</div>

<!-- ACTIVE CAMPAIGNS (NOT REMOVED) -->
<div class="card">
<h2>Active Campaigns

</h2>

<?php
$c = mysqli_query($conn,"SELECT * FROM campaigns WHERE status='active'");
if(mysqli_num_rows($c)){
while($cam=mysqli_fetch_assoc($c)){
$percent = $cam['target_amount']>0
? ($cam['collected_amount']/$cam['target_amount'])*100 : 0;
?>
<p><strong><?= $cam['title'] ?></strong><br>
₹<?= number_format($cam['collected_amount']) ?> /
₹<?= number_format($cam['target_amount']) ?></p>

<div class="progress">
  <div style="width:<?= round($percent) ?>%"></div>
</div>
<small><?= round($percent,1) ?>% funded</small>
<hr>
<?php }} else { echo "No active campaigns"; } ?>
</div>

</div>

</body>
</html>
