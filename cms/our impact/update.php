<?php
include "../../config.php";

$id = $_POST['id'];
$section = $_POST['section'];

// Get existing record
$old_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM our_impact WHERE id=$id"));

/* ---------------- HERO SECTION UPDATE ---------------- */
if ($section == "hero_title") {

    $hero_title = mysqli_real_escape_string($conn, $_POST['hero_title']);

    // Old image
    $old_hero_image = $old_data['hero_image'];

    // If new image uploaded
    if (!empty($_FILES['hero_image']['name'])) {

        $filename = time() . "_" . $_FILES['hero_image']['name'];

        $upload_path = "../../uploads/" . $filename;

        move_uploaded_file($_FILES['hero_image']['tmp_name'], $upload_path);

        $hero_image = $filename;
    } else {
        $hero_image = $old_hero_image;
    }

    // Update query
    mysqli_query($conn, "
        UPDATE our_impact SET 
            hero_title='$hero_title',
            hero_image='$hero_image'
        WHERE id=$id
    ");
}

/* ----------- THE DIFFERENCE WE CREATE UPDATE ------------ */
if ($section == "the_diffrence") {

    $the_diffrence = mysqli_real_escape_string($conn, $_POST['the_diffrence']);

    $old_diff_image = $old_data['the_diffrence_image'];

    if (!empty($_FILES['the_diffrence_image']['name'])) {

        $filename = time() . "_" . $_FILES['the_diffrence_image']['name'];

        $upload_path = "../../uploads/" . $filename;

        move_uploaded_file($_FILES['the_diffrence_image']['tmp_name'], $upload_path);

        $the_diffrence_image = $filename;
    } else {
        $the_diffrence_image = $old_diff_image;
    }

    mysqli_query($conn, "
        UPDATE our_impact SET 
            the_diffrence='$the_diffrence',
            the_diffrence_image='$the_diffrence_image'
        WHERE id=$id
    ");
}

header("Location: view.php");
exit();
?>
