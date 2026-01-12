<?php
include '../config.php';

$sql = "SELECT 
            donors.id,
            donors.full_name, 
            donors.email, 
            donors.phone,
            COUNT(donations.id) AS total_count, 
            SUM(donations.amount) AS total_spent,
            MAX(donations.donated_on) AS last_seen
        FROM donors
        LEFT JOIN donations ON donors.id = donations.donor_id
        GROUP BY donors.id
        ORDER BY total_spent DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Management</title>
    <style>
        body { font-family: Arial; background: #f5f7fb; padding: 20px; }
        .card { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        .btn-view { background: #28c76f; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>

<div class="card">
    <h1><span style="color: #28c76f;">👥</span> Donor Directory</h1>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Donations</th>
                <th>Total Impact</th>
                <th>Last Donation</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><strong><?= htmlspecialchars($row['full_name']) ?></strong></td>
                <td><?= htmlspecialchars($row['email']) ?><br><small><?= htmlspecialchars($row['phone']) ?></small></td>
                <td><?= $row['total_count'] ?> times</td>
                <td>₹<?= number_format($row['total_spent'] ?? 0) ?></td>
                <td><?= $row['last_seen'] ? date('d M Y', strtotime($row['last_seen'])) : 'No data' ?></td>
                <td><a href="donor_profile.php?id=<?= $row['id'] ?>" class="btn-view">View Profile</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>