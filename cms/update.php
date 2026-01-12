<?php
include "../config.php";

$id = $_POST['id'];

$hero_title = mysqli_real_escape_string($conn, $_POST['hero_title']);
$who_we_are = mysqli_real_escape_string($conn, $_POST['who_we_are']);
$vision = mysqli_real_escape_string($conn, $_POST['vision']);
$mission = mysqli_real_escape_string($conn, $_POST['mission']);
$approach = mysqli_real_escape_string($conn, $_POST['approach']);

$founder_name = mysqli_real_escape_string($conn, $_POST['founder_name']);
$founder_title = mysqli_real_escape_string($conn, $_POST['founder_title']);
$founder_description = mysqli_real_escape_string($conn, $_POST['founder_description']);


$old_data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM about_page WHERE id=$id"));


// Hero Image Upload
$old_hero_image = $old_data['hero_image'];

if(!empty($_FILES['hero_image']['name'])){
    $filename = time()."_".$_FILES['hero_image']['name'];
    $upload_path = "../uploads/aadhaar/".$filename;
    
    // Save to database without '../' prefix, just 'uploads/aadhaar/filename'
    $hero_image = "uploads/aadhaar/".$filename;
    
    // Move file to actual location
    move_uploaded_file($_FILES['hero_image']['tmp_name'], $upload_path);
} else {
    $hero_image = $old_hero_image;
}


// Who Image Upload
$old_who_image = $old_data['who_image'];

if(!empty($_FILES['who_image']['name'])){
    $filename = time()."_".$_FILES['who_image']['name'];
    $upload_path = "../uploads/aadhaar/".$filename;
    $who_image = "uploads/aadhaar/".$filename;
    move_uploaded_file($_FILES['who_image']['tmp_name'], $upload_path);
} else {
    $who_image = $old_who_image;
}


// Vision Image Upload
$old_vision_image = $old_data['vision_image'];

if(!empty($_FILES['vision_image']['name'])){
    $filename = time()."_".$_FILES['vision_image']['name'];
    $upload_path = "../uploads/aadhaar/".$filename;
    $vision_image = "uploads/aadhaar/".$filename;
    move_uploaded_file($_FILES['vision_image']['tmp_name'], $upload_path);
} else {
    $vision_image = $old_vision_image;
}


// Mission Image Upload
$old_mission_image = $old_data['mission_image'];

if(!empty($_FILES['mission_image']['name'])){
    $filename = time()."_".$_FILES['mission_image']['name'];
    $upload_path = "../uploads/aadhaar/".$filename;
    $mission_image = "uploads/aadhaar/".$filename;
    move_uploaded_file($_FILES['mission_image']['tmp_name'], $upload_path);
} else {
    $mission_image = $old_mission_image;
}


// Approach Image Upload
$old_approach_image = $old_data['approach_image'];

if(!empty($_FILES['approach_image']['name'])){
    $filename = time()."_".$_FILES['approach_image']['name'];
    $upload_path = "../uploads/aadhaar/".$filename;
    $approach_image = "uploads/aadhaar/".$filename;
    move_uploaded_file($_FILES['approach_image']['tmp_name'], $upload_path);
} else {
    $approach_image = $old_approach_image;
}


// Founder Image Upload
$old_founder_image = $old_data['founder_image'];

if(!empty($_FILES['founder_image']['name'])){
    $filename = time()."_".$_FILES['founder_image']['name'];
    $upload_path = "../uploads/aadhaar/".$filename;
    $founder_image = "uploads/aadhaar/".$filename;
    move_uploaded_file($_FILES['founder_image']['tmp_name'], $upload_path);
} else {
    $founder_image = $old_founder_image;
}


// Update database
$sql = "UPDATE about_page SET 
        hero_title='$hero_title',
        who_we_are='$who_we_are',
        vision='$vision',
        mission='$mission',
        approach='$approach',
        founder_name='$founder_name',
        founder_title='$founder_title',
        founder_description='$founder_description',
        hero_image='$hero_image',
        who_image='$who_image',
        vision_image='$vision_image',
        mission_image='$mission_image',
        approach_image='$approach_image',
        founder_image='$founder_image'
        WHERE id=$id";

mysqli_query($conn,$sql);

header('Location: view_about.php');
exit();

?>