<?php
include "config.php";

$result = mysqli_query($conn, "SELECT * FROM about_page ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_assoc($result);

echo "Current image paths in database:<br>";
echo "Hero: " . $data['hero_image'] . "<br>";
echo "Who: " . $data['who_image'] . "<br>";
echo "Vision: " . $data['vision_image'] . "<br>";
echo "Mission: " . $data['mission_image'] . "<br>";
echo "Approach: " . $data['approach_image'] . "<br>";
echo "Founder: " . $data['founder_image'] . "<br>";

mysqli_close($conn);
?>
