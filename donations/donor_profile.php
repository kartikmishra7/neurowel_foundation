<?php
include '../config.php';
$donor_id = $_GET['id'];

$donor_q = mysqli_query($conn, "SELECT * FROM donors WHERE id = $donor_id");
$donor = mysqli_fetch_assoc($donor_q);


$history_q = mysqli_query($conn, "SELECT * FROM donations WHERE donor_id = $donor_id ORDER BY donated_on DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Profile - <?= $donor['full_name'] ?></title>
    <style>
        body { font-family: Arial; background: #f5f7fb; padding: 40px; }
        .profile-header { background: #fff; padding: 20px; border-radius: 12px; margin-bottom: 20px; border-left: 5px solid #28c76f; }
        .history-card { background: #fff; padding: 20px; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
    </style>
</head>
<body>

<div class="profile-header">
    <a href="donors.php" style="text-decoration:none; color:#28c76f;">← Back to List</a>
    <h1><?= htmlspecialchars($donor['full_name']) ?></h1>
    <p>📧 <?= $donor['email'] ?> | 📞 <?= $donor['phone'] ?></p>
</div>

<div class="history-card">
    <h3>Donation History</h3>
    <table>
        <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Method</th>
            <th>Status</th>
        </tr>
        <?php while($h = mysqli_fetch_assoc($history_q)) { ?>
        <tr>
            <td><?= date('d M Y', strtotime($h['donated_on'])) ?></td>
            <td>₹<?= number_format($h['amount']) ?></td>
            <td><?= ucfirst($h['donation_type']) ?></td>
            <td><?= $h['payment_method'] ?></td>
            <td><span style="color:green;">✔ <?= $h['status'] ?></span></td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>