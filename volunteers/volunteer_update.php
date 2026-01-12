<?php
include '../config.php';

$id = (int)$_POST['id'];

$full_name      = mysqli_real_escape_string($conn,$_POST['full_name']);
$email          = mysqli_real_escape_string($conn,$_POST['email']);
$phone          = mysqli_real_escape_string($conn,$_POST['phone']);
$address        = mysqli_real_escape_string($conn,$_POST['address']);
$aadhaar_number = mysqli_real_escape_string($conn,$_POST['aadhaar_number']);
$status         = $_POST['status'];
$is_active      = (int)$_POST['is_active'];
$volunteer_id   = mysqli_real_escape_string($conn,$_POST['volunteer_id']);

$photo_sql = "";
$aadhaar_sql = "";

/* PROFILE PHOTO UPDATE */
if(!empty($_FILES['photo']['name'])){
    $photo = 'uploads/'.time().'_'.$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "../".$photo);
    $photo_sql = ", photo='$photo'";
}

/* AADHAAR IMAGE UPDATE */
if(!empty($_FILES['aadhaar_image']['name'])){
    $aadhaar = 'uploads/'.time().'_'.$_FILES['aadhaar_image']['name'];
    move_uploaded_file($_FILES['aadhaar_image']['tmp_name'], "../".$aadhaar);
    $aadhaar_sql = ", aadhaar_image='$aadhaar'";
}

mysqli_query($conn,"
UPDATE volunteers SET
full_name='$full_name',
email='$email',
phone='$phone',
address='$address',
aadhaar_number='$aadhaar_number',
status='$status',
is_active=$is_active,
volunteer_id='$volunteer_id'
$photo_sql
$aadhaar_sql
WHERE id=$id
");

header("Location: volunteer_view.php?id=$id");
exit;
