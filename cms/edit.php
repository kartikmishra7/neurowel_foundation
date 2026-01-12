<?php
include "../config.php";
$id = $_GET['id'];
$section = $_GET['section'];

$q = mysqli_query($conn, "SELECT * FROM about_page WHERE id=$id");
$data = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit About Page</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body{
  background:#f8fafc;
  font-family:"Poppins","Segoe UI",Arial,sans-serif;
  margin:0;
  color:#1f2937;
}
input,
textarea,
button,
select{
  font-family:"Poppins","Segoe UI",Arial,sans-serif;
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
  margin-top:0;
  text-align:center;
  font-size:26px;
  font-weight:600;
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
.form-group{
  margin-bottom:20px;
}
label{
  display:block;
  font-weight:500;
  color:#1e40af;
  margin-bottom:6px;
  font-size:14px;
}
textarea{
  width:100%;
  min-height:100px;
  padding:12px 14px;
  border-radius:12px;
  border:1px solid #BFDBFE;
  font-size:14px;
  resize:vertical;
  transition:border-color 0.2s, box-shadow 0.2s;
}
textarea:focus{
  outline:none;
  border-color:#2563eb;
  box-shadow:0 0 0 3px rgba(37,99,235,0.15);
}
input[type="file"]{
  margin-top:10px;
  font-size:13px;
}
.preview{
  margin-top:10px;
}
.preview img{
  max-width:180px;
  border-radius:14px;
  border:1px solid #E5E7EB;
  background:#f9fafb;
}
button{
  width:100%;
  margin-top:30px;
  padding:14px;
  background:linear-gradient(135deg,#2563EB,#1D4ED8);
  color:white;
  border:0;
  border-radius:14px;
  font-size:15px;
  font-weight:600;
  cursor:pointer;
  transition:transform 0.15s ease, box-shadow 0.15s ease;
}
button:hover{
  transform:translateY(-1px);
  box-shadow:0 12px 24px rgba(37,99,235,0.35);
}
@media(max-width:640px){
  .card{padding:22px;}
  h2{font-size:22px;}
}
</style>
</head>
<body>
<div class="wrapper">
  <div class="card">
    <h2>Edit About Page Content</h2>
    <form method="POST" action="update.php" enctype="multipart/form-data">

  <input type="hidden" name="id" value="<?= $data['id'] ?>">
  <input type="hidden" name="section" value="<?= $section ?>">

  <?php if($section == "hero"): ?>
    <div class="section-title">Hero Section</div>

    <label>Hero Title</label>
    <textarea name="hero_title"><?= $data['hero_title'] ?></textarea>

    <div class="preview">
      <?php 
      // Fix image path - remove 'uploads/' prefix if exists
      $hero_image = $data['hero_image'];
      if(strpos($hero_image, 'uploads/') === 0) {
          $hero_image = substr($hero_image, 8);
      }
      ?>
      <img src="../uploads/<?= $hero_image ?>">
    </div>

    <input type="file" name="hero_image">

  <?php endif; ?>


  <?php if($section == "who"): ?>
    <div class="section-title">Who We Are</div>

    <label>Who We Are Content</label>
    <textarea name="who_we_are"><?= $data['who_we_are'] ?></textarea>

    <div class="preview">
      <?php 
      $who_image = $data['who_image'];
      if(strpos($who_image, 'uploads/') === 0) {
          $who_image = substr($who_image, 8);
      }
      ?>
      <img src="../uploads/<?= $who_image ?>">
    </div>

    <input type="file" name="who_image">
  <?php endif; ?>


  <?php if($section == "vision"): ?>
    <div class="section-title">Vision</div>

    <textarea name="vision"><?= $data['vision'] ?></textarea>

    <div class="preview">
      <?php 
      $vision_image = $data['vision_image'];
      if(strpos($vision_image, 'uploads/') === 0) {
          $vision_image = substr($vision_image, 8);
      }
      ?>
      <img src="../uploads/<?= $vision_image ?>">
    </div>

    <input type="file" name="vision_image">
  <?php endif; ?>


  <?php if($section == "mission"): ?>
    <div class="section-title">Mission</div>

    <textarea name="mission"><?= $data['mission'] ?></textarea>

    <div class="preview">
      <?php 
      $mission_image = $data['mission_image'];
      if(strpos($mission_image, 'uploads/') === 0) {
          $mission_image = substr($mission_image, 8);
      }
      ?>
      <img src="../uploads/<?= $mission_image ?>">
    </div>

    <input type="file" name="mission_image">
  <?php endif; ?>


  <?php if($section == "approach"): ?>
    <div class="section-title">Approach</div>

    <textarea name="approach"><?= $data['approach'] ?></textarea>

    <div class="preview">
      <?php 
      $approach_image = $data['approach_image'];
      if(strpos($approach_image, 'uploads/') === 0) {
          $approach_image = substr($approach_image, 8);
      }
      ?>
      <img src="../uploads/<?= $approach_image ?>">
    </div>

    <input type="file" name="approach_image">
  <?php endif; ?>


  <?php if($section == "founder"): ?>
    <div class="section-title">Founder</div>

    <label>Founder Name</label>
    <textarea name="founder_name"><?= $data['founder_name'] ?></textarea>

    <label>Founder Title</label>
    <textarea name="founder_title"><?= $data['founder_title'] ?></textarea>

    <label>Founder Description</label>
    <textarea name="founder_description"><?= $data['founder_description'] ?></textarea>

    <div class="preview">
      <?php 
      $founder_image = $data['founder_image'];
      if(strpos($founder_image, 'uploads/') === 0) {
          $founder_image = substr($founder_image, 8);
      }
      ?>
      <img src="../uploads/<?= $founder_image ?>">
    </div>

    <input type="file" name="founder_image">
  <?php endif; ?>


  <button type="submit">Update Content</button>

</form>

  </div>
</div>
</body>
</html>