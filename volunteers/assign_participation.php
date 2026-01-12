<?php
include '../config.php';


if (isset($_POST['submit_assignment'])) {
    $v_id = $_POST['volunteer_select'];
    $c_id = $_POST['campaign_select'];

    
    $sql = "UPDATE volunteers SET campaign_id = '$c_id' WHERE id = '$v_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Volunteer assigned successfully!');</script>";
    }
}


$volunteers = mysqli_query($conn, "SELECT id, full_name FROM volunteers");
$campaigns = mysqli_query($conn, "SELECT id, title, status FROM campaigns");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Assign Participation</title>
    <style>
        .admin-card { max-width: 500px; margin: 50px auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); font-family: sans-serif; }
        select, button { width: 100%; padding: 12px; margin: 15px 0; border-radius: 8px; border: 1px solid #ddd; }
        button { background: #28c76f; color: white; font-weight: bold; cursor: pointer; border: none; }
        label { font-weight: bold; color: #444; }
    </style>
</head>
<body style="background: #f5f7fb;">

<div class="admin-card">
    <h2>Assign Volunteer Participation</h2>
    <form method="POST">
        <label>1. Select Volunteer</label>
        <select name="volunteer_select" required>
            <option value="">-- Select Person --</option>
            <?php while($v = mysqli_fetch_assoc($volunteers)): ?>
                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['full_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>2. Select Campaign / Event Section</label>
        <select name="campaign_select" required>
            <option value="">-- Select Campaign --</option>
            <?php while($c = mysqli_fetch_assoc($campaigns)): ?>
                <option value="<?= $c['id'] ?>">
                    <?= htmlspecialchars($c['title']) ?> (<?= ucfirst($c['status']) ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="submit_assignment">Confirm Assignment</button>
    </form>
    <a href="campaigns.php" style="display: block; text-align: center; color: #666; text-decoration: none; margin-top: 15px;">← View Campaign Page</a>
</div>

</body>
</html>