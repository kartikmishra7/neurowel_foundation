<?php
include "../../config.php";

$table = $_POST['table'];
$id    = (int)$_POST['id'];

$title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
$desc  = mysqli_real_escape_string($conn, $_POST['description'] ?? '');

/* ---------- GET OLD IMAGE ---------- */
if ($table == "hero_section") {
    $oldQ = mysqli_query($conn, "SELECT hero_image FROM hero_section WHERE id=$id");
    $old  = mysqli_fetch_assoc($oldQ);
    $image = $old['hero_image'] ?? '';
} else {
    $oldQ = mysqli_query($conn, "SELECT image FROM $table WHERE id=$id");
    $old  = mysqli_fetch_assoc($oldQ);
    $image = $old['image'] ?? '';
}

/* ---------- IMAGE UPLOAD (SECURE) ---------- */
if (!empty($_FILES['image']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        die("Only JPG, JPEG, PNG, WEBP images allowed");
    }

    // delete old image
    if (!empty($image) && file_exists("../../uploads/".$image)) {
        unlink("../../uploads/".$image);
    }

    $image = time().'_'.uniqid().'.'.$ext;
    move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/".$image);
}

/* ---------- UPDATE DB ---------- */
if ($table == "hero_section") {
    mysqli_query($conn,
        "UPDATE hero_section SET
            hero_title='$title',
            hero_description='$desc',
            hero_image='$image'
        WHERE id=$id"
    );
} else {
    mysqli_query($conn,
        "UPDATE $table SET
            title='$title',
            description='$desc',
            image='$image'
        WHERE id=$id"
    );
}

header("Location: gallery_admin.php");
exit;
