<?php
include "../../config.php";

$id = $_GET['id'];
$section = $_GET['section'];

$q = mysqli_query($conn, "SELECT * FROM our_impact WHERE id=$id");
$data = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Our Impact Page</title>

<style>
body{
  background:#f8fafc;
  font-family:"Poppins","Segoe UI",Arial,sans-serif;
  margin:0;
  color:#1f2937;
}
.wrapper{
  max-width:1100px;
  margin:40px auto;
  padding:0 20px;
}
.card{
  background:#ffffff;
  padding:32px;
  border-radius:20px;
  box-shadow:0 20px 40px rgba(0,0,0,0.06);
  border:1px solid #E5E7EB;
}
h2{
  text-align:center;
  color:#1e3a8a;
}
.section-title{
  margin-top:36px;
  padding-top:18px;
  border-top:1px dashed #DBEAFE;
  font-size:18px;
  font-weight:500;
  color:#1d4ed8;
}
textarea{
  width:100%;
  min-height:120px;
  padding:12px;
  border-radius:12px;
  border:1px solid #BFDBFE;
}
.preview img{
  max-width:200px;
  margin-top:10px;
  border-radius:12px;
}
button{
  margin-top:25px;
  width:100%;
  padding:14px;
  border-radius:12px;
  border:none;
  color:white;
  background:#1d4ed8;
  cursor:pointer;
}
</style>
</head>

<body>
<div class="wrapper">
<div class="card">

<h2>Edit Our Impact Content</h2>

<form method="POST" action="update.php" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $data['id'] ?>">
<input type="hidden" name="section" value="<?= $section ?>">

<!-- HERO SECTION -->
<?php if($section == "hero_title"): ?>

<div class="section-title">Hero Section</div>

<label>Hero Title</label>
<textarea name="hero_title"><?= $data['hero_title'] ?></textarea>

<div class="preview">
    <?php if($data['hero_image']!=""): ?>
        <img src="../../uploads/<?= $data['hero_image'] ?>" alt="Hero Image">
    <?php endif; ?>
</div>

<label>Change Hero Image</label>
<input type="file" name="hero_image">

<?php endif; ?>

<!-- THE DIFFERENCE WE CREATE -->
<?php if($section == "the_diffrence"): ?>

<div class="section-title">The Difference We Create</div>

<label>Description</label>
<textarea name="the_diffrence"><?= $data['the_diffrence'] ?></textarea>

<div class="preview">
    <?php if($data['the_diffrence_image']!=""): ?>
        <img src="../../uploads/<?= $data['the_diffrence_image'] ?>" alt="Difference Image">
    <?php endif; ?>
</div>

<label>Change Image</label>
<input type="file" name="the_diffrence_image">

<?php endif; ?>

<button type="submit">Update Content</button>

</form>

</div>
</div>

</body>
</html>
