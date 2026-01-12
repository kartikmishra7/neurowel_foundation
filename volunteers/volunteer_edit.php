<?php
include '../config.php';

$id = (int)$_GET['id'];
$q = mysqli_query($conn,"SELECT * FROM volunteers WHERE id=$id");
$v = mysqli_fetch_assoc($q);

if(!$v){
    die("Volunteer not found");
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Volunteer</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

*{font-family:Poppins, sans-serif; box-sizing:border-box}

body{
    background:#eef2f6;
    margin:0;
    padding:25px;
}

/* MAIN CARD */
.container{
    max-width:900px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:18px;
    box-shadow:0 15px 45px rgba(0,0,0,.08);
}

/* TITLE BAR */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.header h2{
    margin:0;
}

/* GRID FORM */
.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px 26px;
    margin-top:10px;
}

label{
    font-size:13px;
    color:#555;
    font-weight:600;
}

input,textarea,select{
    width:100%;
    padding:10px 12px;
    border-radius:10px;
    border:1px solid #d9dee6;
    background:#f9fafb;
    font-size:14px;
}

textarea{
    min-height:80px;
    resize:vertical;
}

/* IMAGE BOXES */
.image-box{
    background:#f8fafc;
    border:1px dashed #cfd8e3;
    padding:12px;
    border-radius:14px;
    text-align:center;
}

.image-box img{
    width:120px;
    border-radius:10px;
    margin-top:10px;
    border:1px solid #e5e7eb;
}

/* BUTTONS */
.actions{
    margin-top:22px;
    text-align:right;
}

button{
    padding:12px 18px;
    border:none;
    border-radius:10px;
    font-size:14px;
    cursor:pointer;
    background:#2563eb;
    color:white;
    box-shadow:0 5px 18px rgba(37,99,235,.35);
    transition:.2s;
}

button:hover{
    transform:translateY(-1px);
}

@media(max-width:780px){
    .form-grid{
        grid-template-columns:1fr;
    }
}

</style>
</head>

<body>

<div class="container">

<div class="header">
<h2>✏️ Edit Volunteer</h2>
</div>

<form method="POST" action="volunteer_update.php" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $v['id'] ?>">

<div class="form-grid">

<!-- LEFT -->
<div>
<label>Full Name</label>
<input type="text" name="full_name" value="<?= $v['full_name'] ?>" required>
</div>

<div>
<label>Email</label>
<input type="email" name="email" value="<?= $v['email'] ?>" required>
</div>

<div>
<label>Phone</label>
<input type="text" name="phone" value="<?= $v['phone'] ?>" required>
</div>
<div>
    <label>volunteers id </label>
<input type="text" value="<?= $v['volunteer_id'] ?>" readonly>
<input type="hidden" name="volunteer_id" value="<?= $v['volunteer_id'] ?>">
</div>

<div style="grid-column: span 2;">
<label>Location</label>
<textarea name="address"><?= $v['address'] ?></textarea>
</div>

<div>
<label>Aadhaar Number</label>
<input type="text" name="aadhaar_number" value="<?= $v['aadhaar_number'] ?>">
</div>

<div>
<label>Status</label>
<select name="status">
    <option value="pending" <?= $v['status']=='pending'?'selected':'' ?>>Pending</option>
    <option value="approved" <?= $v['status']=='approved'?'selected':'' ?>>Approved</option>
    <option value="rejected" <?= $v['status']=='rejected'?'selected':'' ?>>Rejected</option>
</select>
</div>

<div>
<label>Active</label>
<select name="is_active">
    <option value="1" <?= $v['is_active']?'selected':'' ?>>Yes</option>
    <option value="0" <?= !$v['is_active']?'selected':'' ?>>No</option>
</select>
</div>

<!-- PROFILE PHOTO -->
<div class="image-box">
<label>Profile Photo</label>
<input type="file" name="photo">
<br>
<img src="../<?= $v['photo'] ?: 'assets/user.png' ?>">
</div>

<!-- AADHAAR IMAGE -->
<div class="image-box">
<label>Aadhaar Image</label>
<input type="file" name="aadhaar_image">
<br>
<img src="../<?= $v['aadhaar_image'] ?>">
</div>

</div>

<div class="actions">
<button type="submit">💾 Update Volunteer</button>
</div>

</form>

</div>

</body>
</html>
