<?php
include '../config.php';

// fetch campaigns by status
$active_q = mysqli_query($conn, "SELECT * FROM campaigns WHERE status='active' ORDER BY id DESC");
$upcoming_q = mysqli_query($conn, "SELECT * FROM campaigns WHERE status='upcoming' ORDER BY id DESC");
$completed_q = mysqli_query($conn, "SELECT * FROM campaigns WHERE status='completed' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Campaigns & Volunteer Participation</title>

    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f7fb; padding: 30px; }
        .container { max-width: 900px; margin: auto; }

        h1 { color:#222 }

        .section-title { font-size: 22px; color: #333; border-bottom: 3px solid #28c76f; padding-bottom: 8px; margin-top: 40px; }
        .upcoming-title { border-bottom-color: #ff9f43; }
        .completed-title { border-bottom-color: #7367f0; }

        .card { background: #fff; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 6px solid #28c76f; }
        .upcoming-card { border-left-color: #ff9f43; }
        .completed-card { border-left-color: #7367f0; }

        .progress-bg { background: #eee; border-radius: 10px; height: 12px; margin: 15px 0; }
        .progress-fill { background: #28c76f; height: 100%; border-radius: 10px; }

        .vol-box { margin-top: 20px; padding-top: 15px; border-top: 1px solid #f0f0f0; }

        .vol-badge { 
            display: inline-block;
            background: #e7f9ee;
            color: #18a558;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            margin: 5px 5px 0 0;
        }

        .cert-btn {
            text-decoration:none;
            font-size:12px;
            background:#7367f0;
            color:white;
            padding:4px 8px;
            border-radius:6px;
        }

        .no-vol { color: #999; font-size: 13px; font-style: italic; }

        .btn-assign {
            display: inline-block;
            background: #28c76f;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: -21px;
            float:right;
        }

        .btn-complete {
            background:#007bff;
            color:white;
            padding:6px 10px;
            border:none;
            border-radius:6px;
            cursor:pointer;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="assign_volunteer.php" class="btn-assign">➕ Assign Volunteer</a>

    <h1>Campaign Management</h1>

    <!-- ACTIVE -->
    <h2 class="section-title">Active Campaigns</h2>

    <?php if(mysqli_num_rows($active_q) > 0): ?>
        <?php while($cam = mysqli_fetch_assoc($active_q)): 
            $target = $cam['target_amount'] > 0 ? $cam['target_amount'] : 1;
            $collected = $cam['collected_amount'] ?? 0;
            $percent = ($collected / $target) * 100;
        ?>
        <div class="card">

            <h3><?= htmlspecialchars($cam['title']) ?></h3>

            <!-- MARK COMPLETE BUTTON -->
            <form action="mark_complete.php" method="POST" style="display:inline;">
                <input type="hidden" name="campaign_id" value="<?= $cam['id'] ?>">
                <button class="btn-complete">✅ Mark as Completed</button>
            </form>

            <p><strong>Goal:</strong> ₹<?= number_format($target) ?> |
               <strong>Raised:</strong> ₹<?= number_format($collected) ?></p>

            <div class="progress-bg">
                <div class="progress-fill" style="width: <?= min(round($percent),100) ?>%"></div>
            </div>

            <div class="vol-box">
                <strong>Participating Volunteers:</strong><br>

                <?php
                $cid = $cam['id'];
                $vol_q = mysqli_query($conn, "SELECT full_name FROM volunteers WHERE campaign_id = $cid");

                if(mysqli_num_rows($vol_q) > 0){
                    while($vol = mysqli_fetch_assoc($vol_q)){
                        echo "<span class='vol-badge'>👤 ".htmlspecialchars($vol['full_name'])."</span>";
                    }
                } else {
                    echo "<span class='no-vol'>No volunteers assigned yet.</span>";
                }
                ?>
            </div>

        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No active campaigns found.</p>
    <?php endif; ?>



    <!-- COMPLETED CAMPAIGNS -->
    <h2 class="section-title completed-title">Completed Campaigns</h2>

    <?php if(mysqli_num_rows($completed_q) > 0): ?>
        <?php while($cam = mysqli_fetch_assoc($completed_q)): ?>

        <div class="card completed-card">

            <h3><?= htmlspecialchars($cam['title']) ?> ✔</h3>

            <div class="vol-box">
                <strong>Certificates:</strong><br>

                <?php
                $cid = $cam['id'];
                $vol_q = mysqli_query($conn, "SELECT full_name FROM volunteers WHERE campaign_id = $cid");

                if(mysqli_num_rows($vol_q) > 0){
                    while($vol = mysqli_fetch_assoc($vol_q)){
                        $vname = urlencode($vol['full_name']);
                        $cname = urlencode($cam['title']);

                        echo "<span class='vol-badge'>
                                👤 ".htmlspecialchars($vol['full_name'])."
                                <a class='cert-btn' href='generate_certificate.php?vol=$vname&camp=$cname'>
                                    🎓 Generate Certificate
                                </a>
                             </span>";
                    }
                } else {
                    echo "<span class='no-vol'>No volunteers assigned.</span>";
                }
                ?>
            </div>

        </div>

        <?php endwhile; ?>
    <?php else: ?>
        <p>No completed campaigns yet.</p>
    <?php endif; ?>



    <!-- UPCOMING -->
     <a href="create_event.php" class="btn-assign">➕ Create Upcoming Event</a>

    <h2 class="section-title upcoming-title">Upcoming Events</h2>

    <?php if(mysqli_num_rows($upcoming_q) > 0): ?>
        <?php while($up = mysqli_fetch_assoc($upcoming_q)): ?>
        <div class="card upcoming-card">
            <h3><?= htmlspecialchars($up['title']) ?></h3>

            <p>Target Goal: ₹<?= number_format($up['target_amount']) ?></p>

            <p style="color:#ff9f43;font-weight:bold;">Status: Upcoming</p>

            <!-- BUTTON TO MAKE ACTIVE -->
            <form action="mark_active.php" method="POST">
                <input type="hidden" name="campaign_id" value="<?= $up['id'] ?>">
                <button class="btn-complete">🚀 Make Active</button>
            </form>

        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No upcoming events scheduled.</p>
    <?php endif; ?>

</div>

</body>
</html>
