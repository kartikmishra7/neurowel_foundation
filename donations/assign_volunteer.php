<?php
include '../config.php';

// Handle the Form Submission
$message = "";
if (isset($_POST['assign'])) {
    $volunteer_id = $_POST['volunteer_id'];
    $campaign_id = $_POST['campaign_id'];

    $update = mysqli_query($conn, "UPDATE volunteers SET campaign_id = '$campaign_id' WHERE id = '$volunteer_id'");
    
    if ($update) {
        $message = "<div style='color: green; padding: 10px; background: #e7f9ee; border-radius: 5px; margin-bottom: 20px;'>Volunteer successfully assigned!</div>";
    } else {
        $message = "<div style='color: red; padding: 10px; background: #ffebeb; border-radius: 5px; margin-bottom: 20px;'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch all volunteers for the dropdown
$volunteers_res = mysqli_query($conn, "SELECT id, full_name FROM volunteers");

// Fetch only 'active' or 'upcoming' campaigns for the dropdown
$campaigns_res = mysqli_query($conn, "SELECT id, title FROM campaigns WHERE status != 'completed'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Volunteers to Campaigns</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f7fb; padding: 40px; }
        .form-card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        select, button { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; font-size: 16px; }
        button { background: #28c76f; color: white; border: none; cursor: pointer; font-weight: bold; transition: 0.3s; }
        button:hover { background: #1f9d57; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

<div class="form-card">
    <h2 style="text-align: center; color: #333;">Assign a Volunteer</h2>
    <p style="text-align: center; color: #777; font-size: 14px; margin-bottom: 25px;">Link a volunteer to a specific NGO event or campaign.</p>
    
    <?= $message ?>

    <form method="POST">
        <div class="form-group">
            <label>Select Volunteer:</label>
            <select name="volunteer_id" required>
                <option value="">-- Choose Volunteer --</option>
                <?php while($v = mysqli_fetch_assoc($volunteers_res)): ?>
                    <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['full_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Select Campaign/Event:</label>
            <select name="campaign_id" required>
                <option value="">-- Choose Campaign --</option>
                <?php while($c = mysqli_fetch_assoc($campaigns_res)): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" name="assign">Link Volunteer</button>
    </form>

    <a href="campaigns.php" class="back-link">← Back to Campaigns</a>
</div>

</body>
</html>