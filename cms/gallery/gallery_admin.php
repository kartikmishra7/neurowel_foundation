<?php
include "../../config.php";
require_once '../../auth.php';

$auth = new Auth();

if (!$auth->check()) {
    header("Location: ../login.php");
    exit;
}

/* Fetch data */
$hero      = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM hero_section LIMIT 1"));
$sliders   = mysqli_query($conn,"SELECT * FROM slider_images");
$programs  = mysqli_query($conn,"SELECT * FROM programs");
$locations = mysqli_query($conn,"SELECT * FROM locations");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gallery Admin Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
/* ===== GLOBAL ===== */
body{
    margin:0;
    background:#f4f6f8;
    font-family:'Segoe UI',Arial,sans-serif;
    color:#333;
}
.main{
    margin-left:240px;
    padding:30px;
}

/* ===== CARDS ===== */
.card{
    background:#fff5e6;
    border:2px solid #e6cfa8;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
    margin-bottom:30px;
}
.card-header{
    background:#fdebd2;
    color:#1f4ade;
    font-weight:600;
    font-size:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #e6cfa8;
}
.card-body{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
}
.card-body > .card{
    width:220px;
    background:#ffffff;
    border:1px solid #d9d9d9;
    border-radius:10px;
    text-align:center;
    padding-bottom:10px;
}
.card-body img{
    width:100%;
    height:140px;
    object-fit:cover;
    border-radius:8px;
    border:1px solid #ddd;
}

/* ===== BUTTONS ===== */
.btn-container{
    display:flex;
    gap:6px;
    padding:8px 10px;
}
.btn-container .btn{
    flex:1;          /* Make all buttons equal width */
    height:36px;     /* Equal height */
    font-size:22px;
    padding:5;
    text-align:center;
}

/* Colors (original as per your code) */
.btn-primary{
    background:#1f4ade;;
    border-color:#4caf50;
}
.btn-primary:hover{
    background:#43a047;
    border-color:#43a047;
}
.btn-danger{
    background:#1f4ade;
    border-color:#1f4ade;
}
.btn-danger:hover{
    background:#d32f2f;
    border-color:#d32f2f;
}
.btn-success{
    background:#1976d2;
    border-color:#1976d2;
}
.btn-success:hover{
    background:#1565c0;
    border-color:#1565c0;
}

/* Responsive */
@media(max-width:768px){
    .main{margin-left:0;padding:15px;}
    .card-body>.card{width:100%;}
}
</style>
</head>
<body>

<?php include '../../sidebar.php'; ?>

<div class="main">
  <h1>Gallery</h1>

  <!-- ================= HERO ================= -->
  <div class="card">
    <div class="card-header">
        <span>Hero Section</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#heroModal">Edit</button>
    </div>
    <div class="card-body text-center d-block">
      <?php if($hero && $hero['hero_image'] && file_exists("../../uploads/".$hero['hero_image'])): ?>
        <img src="../../uploads/<?= $hero['hero_image'] ?>" style="max-height:300px" class="mb-3 img-fluid">
      <?php endif; ?>
      <h4><?= $hero['hero_title'] ?? '' ?></h4>
      <p><?= $hero['hero_description'] ?? '' ?></p>
    </div>
  </div>

  <!-- Hero Modal -->
  <div class="modal fade" id="heroModal">
    <div class="modal-dialog"><div class="modal-content">
      <form action="update.php" method="post" enctype="multipart/form-data">
        <div class="modal-header"><h5>Edit Hero</h5></div>
        <div class="modal-body">
          <input type="hidden" name="table" value="hero_section">
          <input type="hidden" name="id" value="<?= $hero['id'] ?>">
          <input class="form-control mb-2" name="title" value="<?= $hero['hero_title'] ?>" placeholder="Hero Title">
          <textarea class="form-control mb-2" name="description" placeholder="Hero Description"><?= $hero['hero_description'] ?></textarea>
          <input type="file" name="image" class="form-control">
        </div>
        <div class="modal-footer">
          <button class="btn btn-success">Update</button>
        </div>
      </form>
    </div></div>
  </div>

  <!-- ================= SLIDER ================= -->
  <div class="card">
    <div class="card-header"><span>Slider Images</span></div>
    <div class="card-body">
      <?php while($s=mysqli_fetch_assoc($sliders)): ?>
      <div class="card">
        <img src="../../uploads/<?= $s['image'] ?>">
        <div class="card-body">
          <h6><?= $s['title'] ?></h6>
          <div class="btn-container">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#slider<?= $s['id'] ?>">Edit</button>
            <a href="delete.php?table=slider_images&id=<?= $s['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
          </div>
        </div>
      </div>

      <!-- Slider Modal -->
      <div class="modal fade" id="slider<?= $s['id'] ?>">
        <div class="modal-dialog"><div class="modal-content">
          <form action="update.php" method="post" enctype="multipart/form-data">
            <div class="modal-header"><h5>Edit Slider</h5></div>
            <div class="modal-body">
              <input type="hidden" name="table" value="slider_images">
              <input type="hidden" name="id" value="<?= $s['id'] ?>">
              <input class="form-control mb-2" name="title" value="<?= $s['title'] ?>" placeholder="Title">
              <input type="file" name="image" class="form-control">
            </div>
            <div class="modal-footer">
              <button class="btn btn-success">Update</button>
            </div>
          </form>
        </div></div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- ================= PROGRAMS ================= -->
  <div class="card">
    <div class="card-header"><span>Programs</span></div>
    <div class="card-body">
      <?php while($p=mysqli_fetch_assoc($programs)): ?>
      <div class="card">
        <img src="../../uploads/<?= $p['image'] ?>">
        <div class="card-body">
          <h6><?= $p['title'] ?></h6>
          <div class="btn-container">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#program<?= $p['id'] ?>">Edit</button>
            <a href="delete.php?table=programs&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
          </div>
        </div>
      </div>

      <!-- Program Modal -->
      <div class="modal fade" id="program<?= $p['id'] ?>">
        <div class="modal-dialog"><div class="modal-content">
          <form action="update.php" method="post" enctype="multipart/form-data">
            <div class="modal-header"><h5>Edit Program</h5></div>
            <div class="modal-body">
              <input type="hidden" name="table" value="programs">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <input class="form-control mb-2" name="title" value="<?= $p['title'] ?>" placeholder="Program Title">
              <textarea class="form-control mb-2" name="description" placeholder="Program Description"><?= $p['description'] ?></textarea>
              <input type="file" name="image" class="form-control">
            </div>
            <div class="modal-footer">
              <button class="btn btn-success">Update</button>
            </div>
          </form>
        </div></div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- ================= LOCATIONS ================= -->
  <div class="card">
    <div class="card-header"><span>Locations</span></div>
    <div class="card-body">
      <?php while($l=mysqli_fetch_assoc($locations)): ?>
      <div class="card">
        <img src="../../uploads/<?= $l['image'] ?>">
        <div class="card-body">
          <h6><?= $l['title'] ?></h6>
          <div class="btn-container">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#loc<?= $l['id'] ?>">Edit</button>
            <a href="delete.php?table=locations&id=<?= $l['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
          </div>
        </div>
      </div>

      <!-- Location Modal -->
      <div class="modal fade" id="loc<?= $l['id'] ?>">
        <div class="modal-dialog"><div class="modal-content">
          <form action="update.php" method="post" enctype="multipart/form-data">
            <div class="modal-header"><h5>Edit Location</h5></div>
            <div class="modal-body">
              <input type="hidden" name="table" value="locations">
              <input type="hidden" name="id" value="<?= $l['id'] ?>">
              <input class="form-control mb-2" name="title" value="<?= $l['title'] ?>" placeholder="Location Title">
              <textarea class="form-control mb-2" name="description" placeholder="Location Description"><?= $l['description'] ?></textarea>
              <input type="file" name="image" class="form-control">
            </div>
            <div class="modal-footer">
              <button class="btn btn-success">Update</button>
            </div>
          </form>
        </div></div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

</div>
</body>
</html>
