<?php
include '../config.php';

// Current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// Base URL for links (adjust if the file is inside a subfolder)
$base_url = '../';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Volunteer Management</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<!-- Bootstrap Icons for sidebar icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
/* ---------- GLOBAL ---------- */
*{ font-family:"Poppins",sans-serif; margin:2; padding:0; box-sizing:border-box; }
body{ background:#f4f6f8; }

/* ---------- SIDEBAR ---------- */
.sidebar{
    width:240px;
    min-height:100vh;
    background:#1e3a8a;
    position:fixed;
    left:0;
    top:0;
    padding:20px 15px;
    z-index:1000;
    overflow-y:auto;
}
.sidebar h5{ color:#fff; font-weight:600; margin-bottom:20px; text-align:center; }
.sidebar a{
    color:#fff; text-decoration:none; display:block;
    padding:10px 12px; border-radius:8px; margin-bottom:6px; font-size:14px; transition:.3s;
}
.sidebar a:hover{ background:rgba(255,255,255,0.2); }
.sidebar a.active{ background:#fff; color:#1e3a8a; font-weight:bold; }
.sidebar .sub-link{ padding-left:25px; font-size:13px; opacity:.9; }
.sidebar .sub-link.active{ background:#fff; color:#1e3a8a; font-weight:bold; }

/* Submenu collapse */
.sub-menu{ display:none; flex-direction:column; gap:2px; margin-left:5px; }
.sub-menu.show{ display:flex; }

/* ---------- MAIN CONTENT ---------- */
.main{ margin-left:260px; padding:25px; }

/* ---------- BUTTONS ---------- */
button,.btn{
    background:#0d6efd; color:#fff; padding:8px 14px; border:none;
    border-radius:8px; cursor:pointer; text-decoration:none; font-size:13px;
}
.btn-danger{background:#dc3545;}
.btn-success{background:#198754;}
.btn-warning{background:#ffc107;color:#000;}
.btn-secondary{background:#6c757d;}

/* ---------- FORM ---------- */
.formCard{
    background:#fff; padding:22px; border-radius:14px; border:1px solid #e5e7eb; margin-top:18px;
}
.formGrid{ display:grid; grid-template-columns:1fr 1fr; gap:25px; }
label{ font-size:13px; font-weight:600; margin-bottom:5px; display:block; }
input{ width:100%; padding:9px; border:1px solid #ccc; border-radius:8px; margin-bottom:14px; }
.submitBtn{ margin-top:10px; padding:10px 18px; background:#0d6efd; color:#fff; border:none; border-radius:8px; cursor:pointer; }

/* ---------- TABLES ---------- */
table{ width:100%; border-collapse:collapse; margin-top:15px; }
th{ background:#0d6efd; color:#fff; padding:10px; text-align:left; white-space:nowrap; }
td{ padding:42px; background:#fff; border-bottom:1px solid #ddd; vertical-align:middle; }
img.photo{ width:50px; height:50px; border-radius:50%; object-fit:cover; }
.badge{ padding:4px 10px; border-radius:20px; font-size:12px; color:#fff; }
.pending{background:#ffc107;color:#000;}
.approved{background:#198754;}
.action-col{ display:flex; gap:6px; flex-wrap:wrap; }

/* ---------- RESPONSIVE ---------- */
@media(max-width:900px){ .main{ margin-left:0; padding:42px; } .sidebar{ width:100%; position:relative; min-height:auto; } }
@media(max-width:768px){ .formGrid{ grid-template-columns:1fr; } }
</style>
</head>
<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <h5><i class="bi bi-heart-fill"></i> Neurowel</h5>

    <a href="<?= $base_url ?>index.php" class="<?= $current_page=='index.php'?'active':'' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="<?= $base_url ?>users.php" class="<?= $current_page=='users.php'?'active':'' ?>"><i class="bi bi-people"></i> Users</a>

    <!-- CMS Menu -->
    <a href="javascript:void(0);" onclick="toggleSubmenu('cmsMenu')"><i class="bi bi-layout-text-window"></i> CMS</a>
    <div class="sub-menu" id="cmsMenu">
        <a class="sub-link <?= $current_page=='veiw.php'?'active':'' ?>" href="<?= $base_url ?>cms/homepage/veiw.php">Home Page</a>
        <a class="sub-link <?= $current_page=='view_about.php'?'active':'' ?>" href="<?= $base_url ?>cms/view_about.php">About Page</a>
        <a class="sub-link <?= $current_page=='view.php'?'active':'' ?>" href="<?= $base_url ?>cms/what we do/view.php">What We Do</a>
        <a class="sub-link <?= $current_page=='view.php'?'active':'' ?>" href="<?= $base_url ?>cms/our impact/view.php">Our Impact</a>
        <a class="sub-link <?= $current_page=='gallery_admin.php'?'active':'' ?>" href="<?= $base_url ?>cms/gallery/gallery_admin.php">Gallery</a>
        <a class="sub-link <?= $current_page=='veiw.php'?'active':'' ?>" href="<?= $base_url ?>cms/contact/veiw.php">Contact</a>
        <a class="sub-link <?= $current_page=='get_involved_admin.php'?'active':'' ?>" href="<?= $base_url ?>cms/get_involved/get_involved_admin.php">Get Involved</a>
    </div>

    <a href="<?= $base_url ?>volunteers/volunteer.php" class="<?= $current_page=='volunteer.php'?'active':'' ?>"><i class="bi bi-person-check"></i> Volunteers</a>
    <a href="<?= $base_url ?>donations/dashboard.php" class="<?= $current_page=='dashboard.php'?'active':'' ?>"><i class="bi bi-cash-stack"></i> Donations</a>
    <a href="<?= $base_url ?>campaigns.php" class="<?= $current_page=='campaigns.php'?'active':'' ?>"><i class="bi bi-flag"></i> Campaigns</a>
    <a href="<?= $base_url ?>reports.php" class="<?= $current_page=='reports.php'?'active':'' ?>"><i class="bi bi-graph-up"></i> Reports</a>
    <a href="<?= $base_url ?>settings.php" class="<?= $current_page=='settings.php'?'active':'' ?>"><i class="bi bi-gear"></i> Settings</a>
    <hr style="border-color:rgba(255,255,255,0.3)">
    <a href="<?= $base_url ?>logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="main">
    <h2>Volunteer Management</h2>

    <button onclick="document.getElementById('formBox').style.display='block'">➕ Add Volunteer</button>

    <!-- ADD VOLUNTEER FORM -->
    <div id="formBox" style="display:none">
        <div class="formCard">
            <form action="volunteer_save.php" method="POST" enctype="multipart/form-data">
                <h3>Add New Volunteer</h3>
                <div class="formGrid">
                    <div>
                        <label>Full Name</label>
                        <input type="text" name="full_name" required>
                        <label>Email</label>
                        <input type="email" name="email" required>
                        <label>Phone</label>
                        <input type="text" name="phone" required>
                        <label>Location</label>
                        <input type="text" name="address" required>
                    </div>
                    <div>
                        <label>Profile Image</label>
                        <input type="file" name="photo" accept="image/*" required>
                        <label>Aadhaar Number</label>
                        <input type="text" name="aadhaar_number" maxlength="12" required>
                        <label>Aadhaar Image</label>
                        <input type="file" name="aadhaar_image" accept="image/*" required>
                    </div>
                </div>
                <button type="submit" class="submitBtn">Submit Volunteer</button>
            </form>
        </div>
    </div>

    <hr>
    <div style="display:flex;justify-content:flex-end;margin-bottom:10px;">
        <a href="volunteer_export.php" class="btn btn-secondary">⬇ Export All Volunteers</a>
    </div>

    <!-- PENDING VOLUNTEERS -->
    <h3>Pending Volunteers</h3>
    <table>
        <tr>
            <th>Photo</th>
            <th>Volunteer ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Aadhaar</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        $pending = mysqli_query($conn,"SELECT * FROM volunteers WHERE status='pending' ORDER BY id DESC");
        while($v = mysqli_fetch_assoc($pending)){
            $photo = !empty($v['photo']) ? $v['photo'] : 'assets/user.png';
        ?>
        <tr>
            <td><img src="../<?= $photo ?>" class="photo"></td>
            <td><?= $v['volunteer_id'] ?: 'Not Assigned' ?></td>
            <td><?= htmlspecialchars($v['full_name']) ?></td>
            <td><?= htmlspecialchars($v['email']) ?></td>
            <td>XXXX-XXXX-<?= substr($v['aadhaar_number'],-4) ?></td>
            <td><span class="badge pending">Pending</span></td>
            <td class="action-col">
                <a class="btn-success btn" href="volunteer_action.php?id=<?= $v['id'] ?>&type=approve">Approve</a>
                <a class="btn-danger btn" href="volunteer_action.php?id=<?= $v['id'] ?>&type=reject">Reject</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <hr>

    <!-- APPROVED VOLUNTEERS -->
    <h3>Approved Volunteers</h3>
    <table>
        <tr>
            <th>Photo</th>
            <th>Volunteer ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Active</th>
            <th>Action</th>
        </tr>
        <?php
        $approved = mysqli_query($conn,"SELECT * FROM volunteers WHERE status='approved' ORDER BY id DESC");
        while($v = mysqli_fetch_assoc($approved)){
            $photo = !empty($v['photo']) ? $v['photo'] : 'assets/user.png';
        ?>
        <tr>
            <td><img src="../<?= $photo ?>" class="photo"></td>
            <td><?= $v['volunteer_id'] ?: 'Not Assigned' ?></td>
            <td><?= htmlspecialchars($v['full_name']) ?></td>
            <td><?= htmlspecialchars($v['email']) ?></td>
            <td><span class="badge approved">Approved</span></td>
            <td><?= $v['is_active']?'✔ Active':'✖ Inactive' ?></td>
            <td class="action-col">
                <?php if(!$v['is_active']){ ?>
                <a class="btn-warning btn" href="volunteer_action.php?id=<?= $v['id'] ?>&type=activate">Activate</a>
                <?php } ?>
                <a class="btn-secondary btn" href="volunteer_view.php?id=<?= $v['id'] ?>">View</a>
                <a class="btn btn" href="volunteer_edit.php?id=<?= $v['id'] ?>">Edit</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<script>
function toggleSubmenu(id){
    const menu = document.getElementById(id);
    menu.classList.toggle('show');
}
</script>

</body>
</html>
