<?php
include '../config.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Export Volunteers</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{ font-family:"Poppins",sans-serif; box-sizing:border-box; }
body{ background:#f1f5f9; padding:25px; }
.container{
    background:#fff;
    padding:25px;
    border-radius:14px;
    max-width:1200px;
    margin:auto;
}
.btn{
    background:#0d6efd;
    color:#fff;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    margin-right:6px;
}
.btn-success{background:#198754;}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}
th{
    background:#0d6efd;
    color:#fff;
    padding:10px;
    text-align:left;
}
td{
    padding:10px;
    background:#f8fafc;
    border-bottom:1px solid #ddd;
}
</style>
</head>

<body>
<div class="container">

<h2>All Volunteers</h2>

<div style="margin-bottom:15px;">
    <a href="volunteer_download.php" class="btn btn-success">
        ⬇ Download CSV
    </a>
    <a href="volunteer.php" class="btn">
        ← Back
    </a>
</div>

<table>
<tr>
    <th>Volunteer ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Location</th>
    <th>Aadhaar Number</th>
    <th>Status</th>
    <th>Active</th>
</tr>

<?php
$q = mysqli_query($conn, "SELECT * FROM volunteers ORDER BY id DESC");
while($v = mysqli_fetch_assoc($q)){
?>
<tr>
    <td><?= htmlspecialchars($v['volunteer_id'] ?: 'Not Assigned') ?></td>
    <td><?= htmlspecialchars($v['full_name']) ?></td>
    <td><?= htmlspecialchars($v['email']) ?></td>
    <td><?= htmlspecialchars($v['phone']) ?></td>
    <td><?= htmlspecialchars($v['address']) ?></td>

    <!-- Aadhaar (masked for security) -->
    <td><?= 'XXXX-XXXX-' . substr($v['aadhaar_number'], -4) ?></td>

    <td><?= ucfirst($v['status']) ?></td>
    <td><?= $v['is_active'] ? 'Yes' : 'No' ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
