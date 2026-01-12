<?php
ob_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngo_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_POST['id'];


$hero_title     = $_POST['hero_title'] ?? '';
$program        = $_POST['program_title'] ?? '';
$clothing       = $_POST['clothing_title'] ?? '';
$eduction       = $_POST['eduction_title'] ?? '';
$livelihood     = $_POST['livelihood_title'] ?? '';
$mental         = $_POST['mental_title'] ?? '';
$community      = $_POST['community_title'] ?? '';

// get old data
$old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM who_we_are WHERE id=$id"));

// Save all uploads in the main project uploads folder: C:/xampp/htdocs/NGO dashboard/uploads
// From this file (cms/what we do/update.php) that folder is at ../../uploads/
$upload_folder = "../../uploads/";

// HERO IMAGE 
if(!empty($_FILES['hero_image']['name'])){
    $hero_image = time().'_'.$_FILES['hero_image']['name'];
    move_uploaded_file($_FILES['hero_image']['tmp_name'], $upload_folder.$hero_image);
} else {
    $hero_image = $old['hero_image'];
}

// PROGRAM IMAGE 
if(!empty($_FILES['program_image']['name'])){
    $program_image = time().'_'.$_FILES['program_image']['name'];
    move_uploaded_file($_FILES['program_image']['tmp_name'], $upload_folder.$program_image);
} else {
    $program_image = $old['program_image'];
}

//  CLOTHING IMAGe
if(!empty($_FILES['clothing_image']['name'])){
    $clothing_image = time().'_'.$_FILES['clothing_image']['name'];
    move_uploaded_file($_FILES['clothing_image']['tmp_name'], $upload_folder.$clothing_image);
} else {
    $clothing_image = $old['clothing_image'];
}

//  EDUCATION IMAGE 
if(!empty($_FILES['eduction_image']['name'])){
    $eduction_image = time().'_'.$_FILES['eduction_image']['name'];
    move_uploaded_file($_FILES['eduction_image']['tmp_name'], $upload_folder.$eduction_image);
} else {
    $eduction_image = $old['eduction_image'];
}

//  LIVELIHOOD IMAGE 
if(!empty($_FILES['livelihood_image']['name'])){
    $livelihood_image = time().'_'.$_FILES['livelihood_image']['name'];
    move_uploaded_file($_FILES['livelihood_image']['tmp_name'], $upload_folder.$livelihood_image);
} else {
    $livelihood_image = $old['livelihood_image'];
}

//  MENTAL IMAGE 
if(!empty($_FILES['mental_image']['name'])){
    $mental_image = time().'_'.$_FILES['mental_image']['name'];
    move_uploaded_file($_FILES['mental_image']['tmp_name'], $upload_folder.$mental_image);
} else {
    $mental_image = $old['mental_image'];
}

//  COMMUNITY IMAGE 
if(!empty($_FILES['community_image']['name'])){
    $community_image = time().'_'.$_FILES['community_image']['name'];
    move_uploaded_file($_FILES['community_image']['tmp_name'], $upload_folder.$community_image);
} else {
    $community_image = $old['community_image'];
}

// final update query
$sql = "UPDATE who_we_are SET
    hero_title='$hero_title',
    program_title='$program',
    clothing_title='$clothing',
    eduction_title='$eduction',
    livelihood_title='$livelihood',
    mental_title='$mental',
    community_title='$community',

    hero_image='$hero_image',
    program_image='$program_image',
    clothing_image='$clothing_image',
    eduction_image='$eduction_image',
    livelihood_image='$livelihood_image',
    mental_image='$mental_image',
    community_image='$community_image'

    WHERE id=$id";

mysqli_query($conn, $sql);


header("Location: view.php");
exit();

ob_end_flush();
?>
