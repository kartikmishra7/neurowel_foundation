<?php
include '../config.php';


$sql = "SELECT 
            donors.full_name, 
            donors.email, 
            COUNT(donations.id) AS total_times, 
            SUM(donations.amount) AS total_amount 
        FROM donations 
        INNER JOIN donors ON donations.donor_id = donors.id 
        GROUP BY donations.donor_id 
        HAVING COUNT(donations.id) > 1 
        ORDER BY total_times DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recurring Donors</title>
    <style>
        body { font-family: Arial; background: #f5f7fb; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #fafafa; color: #666; }
        .count-badge { background: #28c76f; color: #fff; padding: 3px 8px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>

<div class="card">
    <h2><span style="color: #28c76f;">❤</span> Recurring Supporters</h2>
    <p>These donors have contributed more than once.</p>

    <table>
        <thead>
            <tr>
                <th>Donor Name</th>
                <th>Email</th>
                <th>Total Times</th>
                <th>Total Contributed</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { 
            ?>
            <tr>
                <td><strong><?= htmlspecialchars($row['full_name']) ?></strong></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><span class="count-badge"><?= $row['total_times'] ?></span></td>
                <td>₹<?= number_format($row['total_amount']) ?></td>
            </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='4'>No recurring donors found yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <br>
    <a href="dashboard.php" style="color: #666; text-decoration: none;">← Back to Dashboard</a>
</div>

</body>
</html>