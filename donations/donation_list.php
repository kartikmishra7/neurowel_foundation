<?php
include '../config.php';

/* FETCH ALL DONATIONS */
$query = "SELECT * FROM donations ORDER BY donated_on DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>All Donations | NGO Admin</title>

<style>
body{
    font-family: Arial, sans-serif;
    background:#f5f7fb;
    padding:40px;
}

.container{
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}

.back-btn{
    text-decoration:none;
    color:#28c76f;
    font-weight:bold;
    margin-bottom:20px;
    display:inline-block;
}

h1{ margin-bottom:5px; }
p{ color:#555; }

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th{
    background:#f8f9fa;
    text-align:left;
    padding:12px;
    border-bottom:2px solid #eee;
}

td{
    padding:12px;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#fcfcfc;
}

.badge{
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
    display:inline-block;
}

.recurring{
    background:#e2f6ff;
    color:#007bff;
}

.one-time{
    background:#fff3cd;
    color:#856404;
}

.status-success{
    color:#18a558;
    font-weight:bold;
}

.na{
    color:#999;
}
</style>
</head>

<body>

<div class="container">

<a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

<h1>All Donation History</h1>
<p>A complete list of every contribution received by the NGO.</p>

<table>
<thead>
<tr>
    <th>Donor Name</th>
    <th>Email</th>
    <th>Amount</th>
    <th>Type</th>
    <th>Payment Method</th>
    <th>Date</th>
    <th>Status</th>
</tr>
</thead>

<tbody>
<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){

        /* SAFE DATE HANDLING */
        if(!empty($row['donated_on'])){
            $date = date('M d, Y', strtotime($row['donated_on']));
        }else{
            $date = '<span class="na">N/A</span>';
        }

        $donor_name  = $row['donor_name']  ?? 'Anonymous';
        $donor_email = $row['donor_email'] ?? 'N/A';
        $type        = $row['donation_type'] ?? 'one-time';
?>
<tr>
    <td><strong><?= htmlspecialchars($donor_name) ?></strong></td>
    <td><?= htmlspecialchars($donor_email) ?></td>
    <td>₹<?= number_format($row['amount'], 2) ?></td>

    <td>
        <span class="badge <?= $type == 'recurring' ? 'recurring' : 'one-time' ?>">
            <?= ucfirst($type) ?>
        </span>
    </td>

    <td><?= ucfirst($row['payment_method']) ?></td>

    <td><?= $date ?></td>

    <td>
        <span class="status-success">● <?= ucfirst($row['status']) ?></span>
    </td>
</tr>
<?php
    }
}else{
    echo "<tr><td colspan='7'>No donations found.</td></tr>";
}
?>
</tbody>
</table>

</div>

</body>
</html>
