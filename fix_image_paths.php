<?php
include "config.php";

$sql = "UPDATE about_page SET
        hero_image = REPLACE(hero_image, 'uploads/', 'uploads/aadhaar/'),
        who_image = REPLACE(who_image, 'uploads/', 'uploads/aadhaar/'),
        vision_image = REPLACE(vision_image, 'uploads/', 'uploads/aadhaar/'),
        mission_image = REPLACE(mission_image, 'uploads/', 'uploads/aadhaar/'),
        approach_image = REPLACE(approach_image, 'uploads/', 'uploads/aadhaar/'),
        founder_image = REPLACE(founder_image, 'uploads/', 'uploads/aadhaar/')
        WHERE hero_image LIKE 'uploads/%'";

if (mysqli_query($conn, $sql)) {
    echo "Image paths updated successfully.";
} else {
    echo "Error updating paths: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
