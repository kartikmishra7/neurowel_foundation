<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

/* ---------- SAFE INPUT ---------- */
$full_name = mysqli_real_escape_string($conn, $_POST['full_name'] ?? '');
$email     = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$phone     = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
$address   = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
$aadhaar_number = mysqli_real_escape_string($conn, $_POST['aadhaar_number'] ?? '');

/* ---------- REQUIRED FIELD CHECK ---------- */
if ($full_name == '' || $email == '' || $phone == '' || $aadhaar_number == '') {
    die("Required fields are missing");
}

/* ---------- CHECK DUPLICATE EMAIL ---------- */
$checkEmail = mysqli_query(
    $conn,
    "SELECT id FROM volunteers WHERE email='$email' LIMIT 1"
);

if (mysqli_num_rows($checkEmail) > 0) {
    die("This email is already registered as a volunteer.");
}

/* ---------- CREATE UPLOAD FOLDER ---------- */
$uploadDir = "../uploads/volunteers/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* ---------- IMAGE SETTINGS ---------- */
$allowed = ['jpg','jpeg','png','webp'];

/* ---------- PROFILE PHOTO ---------- */
$photo = '';
if (!empty($_FILES['photo']['name'])) {
    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        die("Invalid profile photo format");
    }
    $photo = "uploads/volunteers/".time()."_photo.".$ext;
    move_uploaded_file($_FILES['photo']['tmp_name'], "../".$photo);
}

/* ---------- AADHAAR IMAGE ---------- */
$aadhaar_image = '';
if (!empty($_FILES['aadhaar_image']['name'])) {
    $ext = strtolower(pathinfo($_FILES['aadhaar_image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        die("Invalid Aadhaar image format");
    }
    $aadhaar_image = "uploads/volunteers/".time()."_aadhaar.".$ext;
    move_uploaded_file($_FILES['aadhaar_image']['tmp_name'], "../".$aadhaar_image);
}

/* ---------- VOLUNTEER ID ---------- 
$volunteer_id = "VOL-" . rand(1000,9999);*/

/* ---------- INSERT ---------- */
$q = mysqli_query($conn,"
INSERT INTO volunteers
(volunteer_id, full_name, email, phone, photo, address, aadhaar_number, aadhaar_image, status, is_active)
VALUES
('$volunteer_id','$full_name','$email','$phone','$photo','$address','$aadhaar_number','$aadhaar_image','pending',0)
");

if (!$q) {
    die("Database Error: " . mysqli_error($conn));
}

header("Location: volunteer.php");
exit;
