<?php
include '../config.php';
$id = (int)$_GET['id'];

$donor = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT d.*,
SUM(do.amount) AS total,
COUNT(do.id) AS donations,
(SELECT payment_method FROM donations WHERE donor_id=d.id
 GROUP BY payment_method ORDER BY COUNT(*) DESC LIMIT 1) AS preferred
FROM donors d
JOIN donations do ON d.id=do.donor_id
WHERE d.id=$id
"));

$history = mysqli_query($conn,"
SELECT do.*,c.title
FROM donations do
LEFT JOIN campaigns c ON do.campaign_id=c.id
WHERE do.donor_id=$id
ORDER BY do.donated_on DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Donor Profile</title>
<style>
body{font-family:Arial;background:#f5f7fb;padding:20px}
.card{background:#fff;padding:20px;border-radius:12px}
table{width:100%;border-collapse:collapse;margin-top:10px}
th,td{padding:10px;border-bottom:1px solid #ddd}
.btn{padding:8px 14px;background:#28c76f;color:#fff;border-radius:6px;text-decoration:none}
</style>
</head>
<body>

<div class="card">
<h2>Donor Profile</h2>

<p><strong><?= $donor['full_name'] ?></strong></p>
<p><?= $donor['email'] ?></p>
<p><?= $donor['phone'] ?></p>

<hr>

<p>Total Donated: ₹<?= number_format($donor['total']) ?></p>
<p>Donations: <?= $donor['donations'] ?></p>
<p>Preferred Payment: <?= $donor['preferred'] ?></p>

<hr>

<h3>Donation History</h3>

<table>
<tr>
<th>Date</th>
<th>Amount</th>
<th>Payment</th>
<th>Campaign</th>
<th>Receipt</th>
</tr>

<?php while($h=mysqli_fetch_assoc($history)){ ?>
<tr>
<td><?= date('d M',strtotime($h['donated_on'])) ?></td>
<td>₹<?= $h['amount'] ?></td>
<td><?= $h['payment_method'] ?></td>
<td><?= $h['title'] ?? '-' ?></td>
<td><a href="receipt.php?id=<?= $h['id'] ?>">📄</a></td>
</tr>
<?php } ?>

</table>

<br>
<a href="donors.php" class="btn">← Back to Donors</a>

</div>

</body>
</html>
