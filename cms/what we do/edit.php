<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngo_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];
$section = $_GET['section'];

$q = mysqli_query($conn, "SELECT * FROM who_we_are WHERE id=$id");
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
    <h2>Edit who we are Content</h2>
    <form method="POST" action="update.php" enctype="multipart/form-data">

  <input type="hidden" name="id" value="<?= $data['id'] ?>">
  <input type="hidden" name="section" value="<?= $section ?>">

  <?php if($section == "hero_title"): ?>
    <div class="section-title">Hero Section</div>

    <label>Hero Title</label>
    <textarea name="hero_title"><?= $data['hero_title'] ?></textarea>

    <div class="preview">
      <?php 
      $hero_image = $data['hero_image'];
      if(strpos($hero_image, 'uploads/') === 0) {
          $hero_image = substr($hero_image, 8);
      }
      ?>
      <img src="../../uploads/<?= $hero_image ?>">
    </div>

    <input type="file" name="hero_image">

  <?php endif; ?>


  <?php if($section == "program_title"): ?>
    <div class="section-title">program title</div>

    <label>program</label>
    <textarea name="program_title"><?= $data['program_title'] ?></textarea>

    <div class="preview">
      <?php 
      $program_image = $data['program_image'];
      if(strpos($program_image, 'uploads/') === 0) {
          $program_image = substr($program_image, 8);
      }
      ?>
      <img src="../../uploads/<?= $program_image ?>">
    </div>

    <input type="file" name="program_image">
  <?php endif; ?>


  <?php if($section == "clothing_title"): ?>
    <div class="section-title">clothing distribution programs</div>

    <textarea name="clothing_title"><?= $data['clothing_title'] ?></textarea>

    <div class="preview">
      <?php 
      $clothing_image = $data['clothing_image'];
      if(strpos($clothing_image, 'uploads/') === 0) {
          $clothing_image = substr($clothing_image, 8);
      }
      ?>
      <img src="../../uploads/<?= $clothing_image ?>">
    </div>

    <input type="file" name="clothing_image">
  <?php endif; ?>


  <?php if($section == "eduction_title"): ?>
    <div class="section-title">Education support</div>

    <label>Education Title</label>
    <textarea name="eduction_title"><?= $data['eduction_title'] ?></textarea>

    <div class="preview">
      <?php 
      $eduction_image = $data['eduction_image'];
      if(strpos($eduction_image, 'uploads/') === 0) {
          $eduction_image = substr($eduction_image, 8);
      }
      ?>
      <img src="../../uploads/<?= $eduction_image ?>">
    </div>

    <input type="file" name="eduction_image">
  <?php endif; ?>


  <?php if($section == "livelihood_title"): ?>
    <div class="section-title">livehood & skill development</div>

    <textarea name="livelihood_title"><?= $data['livelihood_title'] ?></textarea>

    <div class="preview">
      <?php 
      $livelihood_image = $data['livelihood_image'];
      if(strpos($livelihood_image, 'uploads/') === 0) {
          $livelihood_image = substr($livelihood_image, 8);
      }
      ?>
      <img src="../../uploads/<?= $livelihood_image ?>">
    </div>

    <input type="file" name="livelihood_image">
  <?php endif; ?>


  <?php if($section == "mental_title"): ?>
    <div class="section-title">Mental wellness & emotional development</div>

    <label>Mental Title</label>
    <textarea name="mental_title"><?= $data['mental_title'] ?></textarea>
    
    <div class="preview">
      <?php 
      $mental_image = $data['mental_image'];
      if(strpos($mental_image, 'uploads/') === 0) {
          $mental_image = substr($mental_image, 8);
      }
      ?>
      <img src="../../uploads/<?= $mental_image ?>">
    </div>

    <input type="file" name="mental_image">
  <?php endif; ?>


  <?php if($section == "community_title"): ?>
    <div class="section-title">community development iniatives</div>

    <textarea name="community_title"><?= $data['community_title'] ?></textarea>

    <div class="preview">
      <?php 
      $community_image = $data['community_image'];
      if(strpos($community_image, 'uploads/') === 0) {
          $community_image = substr($community_image, 8);
      }
      ?>
      <img src="../../uploads/<?= $community_image ?>">
    </div>

    <input type="file" name="community_image">
  <?php endif; ?>

  <button type="submit">Update Content</button>

</form>
  </div>
</div>
</body>
</html>